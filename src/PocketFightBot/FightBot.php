<?php

declare(strict_types=1);

namespace PocketFightBot;

use pocketmine\entity\Human;
use pocketmine\entity\Location;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\entity\Skin;
use pocketmine\math\Vector3;

class FightBot extends Human {

    private float $speed = 0.45;
    private float $attackDamage = 6.0;
    private float $reach = 3.5;
    
    private int $attackCooldown = 0;
    private int $jumpTicks = 0;
    private ?string $targetName = null;

    public function __construct(Location $location, Skin $skin, ?CompoundTag $nbt = null) {
        parent::__construct($location, $skin, $nbt);
        $this->setMaxHealth(20);
        $this->setHealth(20);
    }

    public function setAttributes(float $speed, float $damage, float $reach): void {
        $this->speed = $speed;
        $this->attackDamage = $damage;
        $this->reach = $reach;
    }

    protected function entityBaseTick(int $tickDiff = 1): bool {
        $hasUpdate = parent::entityBaseTick($tickDiff);
        
        if (!$this->isAlive()) {
            if (!$this->isClosed()) $this->flagForDespawn();
            return false;
        }

        // Dynamic Health Tag
        $this->setNameTag($this->getNameTag() . "\n§a" . round($this->getHealth(), 1) . " HP");

        // Target Logic
        if (!$this->hasTarget()) {
            $this->findTarget();
        } else {
            $this->combatLogic();
        }

        // Gravity/Physics
        if (!$this->isOnGround()) {
            $this->motion->y -= 0.08; // Standard gravity
        } else {
            $this->motion->y = 0;
        }

        $this->move($this->motion->x, $this->motion->y, $this->motion->z);
        return $hasUpdate;
    }

    private function findTarget(): void {
        $nearest = null;
        $dist = 15; // Scan range

        foreach ($this->getWorld()->getPlayers() as $player) {
            if ($player->isSpectator() || !$player->isAlive()) continue;
            
            $d = $this->getPosition()->distance($player->getPosition());
            if ($d <= $dist) {
                $dist = $d;
                $nearest = $player;
            }
        }

        if ($nearest !== null) {
            $this->targetName = $nearest->getName();
        }
    }

    private function hasTarget(): bool {
        if ($this->targetName === null) return false;
        $target = $this->getWorld()->getPlayerExact($this->targetName);
        if ($target === null || !$target->isAlive() || $target->isSpectator()) {
            $this->targetName = null;
            return false;
        }
        return true;
    }

    private function combatLogic(): void {
        $target = $this->getWorld()->getPlayerExact($this->targetName);
        if ($target === null) return;

        // 1. Look at target
        $this->lookAt($target->getPosition()->add(0, 1.5, 0));

        $dist = $this->getPosition()->distance($target->getPosition());

        // 2. Movement AI
        if ($dist > $this->reach - 0.5) {
            // Move forward
            $direction = $this->getDirectionVector();
            $this->motion->x = $direction->x * $this->speed;
            $this->motion->z = $direction->z * $this->speed;
        } else {
            // Stop moving if close enough to hit
            $this->motion->x = 0;
            $this->motion->z = 0;
        }

        // 3. Jump logic (Simple auto-jump)
        if ($this->isCollidedHorizontally && $this->isOnGround()) {
            $this->jump();
        }

        // 4. Attack Logic
        if ($this->attackCooldown > 0) {
            $this->attackCooldown--;
        }

        if ($dist <= $this->reach && $this->attackCooldown <= 0) {
            $this->attackTarget($target);
            $this->attackCooldown = 10; // 0.5 seconds (standard hit speed)
        }
    }

    private function attackTarget(Player $target): void {
        $event = new EntityDamageByEntityEvent($this, $target, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $this->attackDamage);
        $event->setKnockBack(0.4);
        $target->attack($event);
        $this->broadcastAnimation(new \pocketmine\entity\animation\ArmSwingAnimation($this));
    }
}

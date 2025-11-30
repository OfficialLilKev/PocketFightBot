# ⚔️ PocketFightBot (v2.0)

**PocketFightBot** is a high-performance PvP training plugin for PocketMine-MP 5.0+. Unlike standard NPC plugins, this bot features advanced combat AI that strafes, jumps, and mimics real player movement physics to provide a genuine PvP challenge.

### 🚀 Key Features

* **🧠 Advanced Combat AI:** The bot doesn't just walk in a straight line. It strafes, circles the player, and utilizes "reach" logic to space itself properly during fights.
* **👤 Skin Cloning:** The bot automatically steals the skin of the player who spawns it, creating a perfect "Doppelgänger" effect.
* **⚡ Physics-Based Movement:** Gone are the jittery teleports. This bot uses calculated motion vectors for smooth, reliable knockback and jumping.
* **🩹 Dynamic Health Tags:** The nametag updates in real-time to show the bot's current HP during the fight.
* **⚙️ Fully Configurable:** Control the bot's speed, damage, reach, and health via a simple config file.

---

### 📥 Installation

1. Download the **PocketFightBot** plugin `.phar` or folder.
2. Upload it to your server's `/plugins/` folder.
3. Restart your server.
4. (Optional) Edit the `plugin_data/PocketFightBot/config.yml` file to tweak the difficulty.

---

### 🎮 Usage

To start a fight, simply use the command below. The bot will spawn at your location and immediately begin tracking the nearest player (you).

**Command:**
`/fightbot <name>`

**Example:**
`/fightbot PracticeBot` — *Spawns a bot named "PracticeBot" with your skin.*

> **Note:** The bot will automatically target the nearest player within 15 blocks. If you run away or fly out of range, it will lose interest.

---

### ⚙️ Configuration

You can adjust the difficulty of the bot in `config.yml`.

```yaml
# PocketFightBot Configuration

# The bot's starting HP (20 = 10 hearts)
bot_health: 20

# How fast the bot moves (0.45 is slightly faster than walking)
bot_speed: 0.45

# How much damage the bot deals per hit (in HP)
bot_damage: 6.0

# The distance (in blocks) the bot can hit you from
# 3.0 is standard survival, 3.5 - 4.0 is "sweaty" PvP
reach_distance: 3.5

# If set to true, the bot deals knockback on hits
enable_kb: true

🚀 # LaunchPadPlugin (v2.0)
LaunchPadPlugin is a lightweight, physics-based launchpad solution for PocketMine-MP 5.0+. It replaces old, glitchy teleportation methods with smooth velocity calculations, "throwing" players through the air for a realistic parkour or hub experience.

✨ Key Features
Physics-Based Launching: Uses setMotion() vectors instead of teleportation. Players arc through the air smoothly.

Fully Configurable: Adjust the Forward Force and Vertical Lift to get the perfect jump arc for your lobby.

Multi-Block Support: Define any block as a launchpad in the config (e.g., specific pressure plates, slime blocks, etc.).

Audio Feedback: Plays a sound effect (Ghast Shoot) upon launch (toggleable).

Spam Prevention: Built-in cooldowns prevent players from getting stuck or crashing the server by standing on the plate.

📥 Installation
Download the plugin .phar or source code.

Place it into your server's /plugins/ folder.

Restart the server to generate the default configuration.

⚙️ Configuration
You can find the config.yml in plugin_data/LaunchPadPlugin/.

YAML

# LaunchPadPlugin Configuration

# How strong is the forward push? (Higher = Further distance)
# Recommended: 1.5 - 3.0
force: 2.0

# How much upward lift should they get? (Higher = Higher arc)
# Recommended: 0.5 - 1.5
vertical_lift: 0.8

# Should a sound play when launched?
sound: true

# List of blocks that act as launchpads.
# Use standard Minecraft block names (e.g., oak_pressure_plate).
blocks:
  - "oak_pressure_plate"
  - "spruce_pressure_plate"
  - "heavy_weighted_pressure_plate"
🛠️ Troubleshooting
The pads aren't working:

Ensure you are using the correct block name in the config (e.g., oak_pressure_plate not just wooden_pressure_plate or ID 72).

Check if you are sneaking; some server plugins prevent events while sneaking.

I get launched too far/not far enough:

Tweak the force value in config.yml. A change of 0.5 makes a big difference!

📝 Requirements
PocketMine-MP: 5.0.0 or higher

PHP: 8.1+

Developed for the PocketMine Community.

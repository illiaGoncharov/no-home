# NO HOME - Remote Control Text System

## Implementation Status: ✅ COMPLETED

### Main Page (Stickers & Papers)
- ✅ **All stickers**: "sorry for being weird it's my first time being alive"
- ✅ **Note8 (email sticker)**: "you can leave a note or leave nothing"

### Skeleton Navigation
- ✅ **Skeleton button**: "please, select one of my limbs" (in header.php data-horse-click)

### Bedroom Room
- ✅ **Backpack**: "watch out! Is something or someone behind you? are objects also subjects?"
- ✅ **Backpack (clicked)**: "press to secure/save/survive"
- ✅ **Suitcase**: "watch out! Is something or someone behind you? are objects also subjects?"
- ✅ **Suitcase (clicked)**: "press to secure/save/survive"
- ✅ **Silhouette**: "have you ever been activated? please, check in with your soul. there are many other souls in the walls, it can get confusing."
- ✅ **Window**: "do you know the temperature of air outside someone's window?"
- ✅ **Outside view (click)**: "what is your favorite transmission tower? Though let me not distract you for long, I will hide away shortly."

### Cave Room
- ✅ **Mirror**: "sorry, your reflection is not renderable"
- ✅ **Hopscotch numbers**: "the numbers on your way are a chance to establish contact with them"
- ✅ **Cave**: "do you feel your body temperature right now?"
- ✅ **Safety helmet**: "mind your head"
- ✅ **Flashlight**: "set yourself up for lighting the space"
- ✅ **Walkie-talkie**: "do you know how to listen carefully?"
- ✅ **Speaker**: "do you know how to follow well? are you a considerate person?"

### Golden Room
- ✅ **Loading**: "pixels are in a preparation process. wait for them please. I am sorry if you encounter any bugs."
- ✅ **Doors with locks**: "what do you prefer - closed/open doors or closed/open locks?"
- ✅ **Door lock (after click)**: "do you know how to cipher?"
- ✅ **Outside boundaries**: "welcome to complete isolation"
- ✅ **Mice**: "oh no, i am sorry, the mice have escaped the lab!"

### Table/Attic Room
- ✅ **Coffee table**: "the ground knows so many steps…"
- ✅ **Hard disks**: "don't rush to leave, it's a fine day"
- ✅ **Table**: "I hope this table is adaptive enough for you"
- ✅ **Tablet**: "my heart is surrounded by bones. I am able to hear both the heart and the bones. What about you?"
- ✅ **iPhone**: "this phone doesn't have any secrets and is free for anyone to use"
- ✅ **Camera**: "the motives of this camera are not clear, the date and time are broken"
- ✅ **Window**: "i hear the helicopters and planes behind the window but can't tell whether to expect explosions?"
- ✅ **Outside view (click)**: "please, do not leave. I will hide away shortly and you can scroll."

### Attic Special Feature
- ✅ **13th click on central skeleton**: "the sounds have been stolen by somebody and the moving creatures have been isolated. if you click on the central skeleton in this room 13 times in a row there will be no sound theft and the creatures will synchronize their movements."

## Implementation Files:
- `js/horse-text-handler.js` - Main implementation
- `header.php` - Skeleton button text
- `[local]main.php` - Development preloader skip

## Remote Control Images:
- **пультик.png** - Default state (no player active)
- **пультик-плеер.png** - Player mode state  
- **пауза.png** - Pause button (separate)

## Notes:
- All texts are in English as per artistic project requirements
- Hover interactions for most elements
- Click interactions for specific elements (locks, outside views, bags)
- Special 13-click counter for attic skeleton
- Development mode skips preloader automatically 
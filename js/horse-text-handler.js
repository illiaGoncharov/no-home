// Horse Text Handler - Улучшенная версия

(function() {
    // Debugging flag
    const DEBUG = false;

    // Logging function
    const log = (...args) => {
        if (DEBUG) {
            console.log('🐴', ...args);
        }
    };

    // Default text
    const DEFAULT_TEXT = "you can move me and listen to me. you can close me by pressing the button at the top.";

    // Find the horse text element
    const findHorseTextElement = () => {
        const elements = [
            document.getElementById('hi-update'),
            document.querySelector('.horse-indicator-text'),
            document.querySelector('[data-horse-text]')
        ];

        for (let el of elements) {
            if (el) {
                log('Horse text element found:', el);
                return el;
            }
        }

        console.error('🚨 No horse text element found!');
        return null;
    };

    // Core text update function
    const updateHorseText = (text, options = {}) => {
        const {
            duration = 0,
            force = true,
            debug = false
        } = options;

        const horseTextEl = findHorseTextElement();
        if (!horseTextEl) return;

        try {
            if (debug) console.group('🐴 Horse Text Update');

            const textToSet = text || DEFAULT_TEXT;
            
            // Create scrolling text element if it doesn't exist
            let scrollTextEl = horseTextEl.querySelector('#horse-text-original');
            if (!scrollTextEl) {
                scrollTextEl = document.createElement('div');
                scrollTextEl.id = 'horse-text-original';
                horseTextEl.innerHTML = '';
                horseTextEl.appendChild(scrollTextEl);
            }
            
            scrollTextEl.textContent = textToSet;
            
            // Determine if text needs scrolling
            const isOverflowing = scrollTextEl.scrollWidth > horseTextEl.clientWidth;
            
            if (isOverflowing) {
                horseTextEl.classList.add('marquee');
                scrollTextEl.style.animation = 'scrollText 15s linear infinite';
            } else {
                horseTextEl.classList.remove('marquee');
                scrollTextEl.style.animation = 'none';
                scrollTextEl.style.transform = 'translateX(0)';
            }

            // Force visibility and interactivity
            if (force) {
                Object.assign(horseTextEl.style, {
                    opacity: '1 !important',
                    visibility: 'visible !important',
                    display: 'block !important',
                    color: 'white !important',
                    transform: 'none !important',
                    textShadow: '0 0 10px rgba(255,255,255,0.7)',
                    transition: 'all 0.3s ease'
                });

                // Force parent styles
                const parentWrapper = horseTextEl.closest('.horse-indicator-text-wrapper');
                if (parentWrapper) {
                    Object.assign(parentWrapper.style, {
                        opacity: '1 !important',
                        visibility: 'visible !important'
                    });
                }
            }

            // Trigger events
            ['change', 'input', 'update'].forEach(eventName => {
                const event = new Event(eventName, { bubbles: true });
                horseTextEl.dispatchEvent(event);
            });

            if (debug) console.log('✅ Text forcefully updated');
            if (debug) console.groupEnd();

            // Optional duration-based reset
            if (duration > 0) {
                setTimeout(() => {
                    updateHorseText(DEFAULT_TEXT, { duration: 0, debug: false });
                }, duration);
            }

        } catch (error) {
            console.error('❌ Horse Text Update Failed:', error);
        }
    };

    // Global update function
    window.updateHorseText = (text, duration = 5000) => {
        log('🌐 Global Horse Text Update:', { text, duration });
        updateHorseText(text, { duration });
    };
    
    // Helper function to safely find elements
    const findElements = (selectors, parent = document) => {
        if (typeof selectors === 'string') {
            return Array.from(parent.querySelectorAll(selectors));
        } else if (Array.isArray(selectors)) {
            const elements = [];
            for (const selector of selectors) {
                if (typeof selector === 'string') {
                    elements.push(...Array.from(parent.querySelectorAll(selector)));
                } else if (selector instanceof Element) {
                    elements.push(selector);
                } else if (selector && typeof selector === 'object' && selector.id) {
                    const el = document.getElementById(selector.id);
                    if (el) elements.push(el);
                }
            }
            return elements.filter(Boolean);
        }
        return [];
    };
    
    // Helper function to add hover text interaction to elements
    const setupHoverInteraction = (elements, enterText, leaveText = DEFAULT_TEXT) => {
        const foundElements = findElements(elements);
        
        if (foundElements.length === 0) {
            log('⚠️ No elements found for hover interaction:', elements);
            return;
        }
        
        foundElements.forEach(element => {
            // Ensure we don't add duplicate listeners
            if (!element.hasAttribute('data-horse-text-hover')) {
                element.addEventListener('mouseenter', () => {
                    updateHorseText(enterText);
                });
                
                element.addEventListener('mouseleave', () => {
                    updateHorseText(leaveText);
                });
                
                // Mark that we've set up hover interaction
                element.setAttribute('data-horse-text-hover', 'true');
                
                log('✅ Hover interaction added for:', element);
            }
        });
        
        return foundElements;
    };
    
    // Helper function to add click text interaction to elements
    const setupClickInteraction = (elements, clickText, duration = 5000) => {
        const foundElements = findElements(elements);
        
        if (foundElements.length === 0) {
            log('⚠️ No elements found for click interaction:', elements);
            return;
        }
        
        foundElements.forEach(element => {
            // Ensure we don't add duplicate listeners
            if (!element.hasAttribute('data-horse-text-click')) {
                element.addEventListener('click', () => {
                    updateHorseText(clickText, { duration });
                });
                
                // Mark that we've set up click interaction
                element.setAttribute('data-horse-text-click', 'true');
                
                log('✅ Click interaction added for:', element);
            }
        });
        
        return foundElements;
    };

    // Initialize with default text
    document.addEventListener('DOMContentLoaded', () => {
        log('🏁 Horse Text Handler Initialized');
        updateHorseText(DEFAULT_TEXT);

        // Setup sticker interactions
        const setupStickerInteractions = () => {
            // Clear any existing handlers to prevent duplicates
            const stickerImgs = document.querySelectorAll(".sticker-img");
            
            stickerImgs.forEach(sticker => {
                // Only set up handlers if they haven't been added before
                if (!sticker.hasAttribute('data-horse-handled')) {
                    // Note8 stickers - email input sticker
                    if (sticker.classList.contains("note8")) {
                        setupHoverInteraction([sticker], "you can leave a note or leave nothing");
                    } else {
                        // All other paper stickers
                        setupHoverInteraction([sticker], "sorry for being weird it's my first time being alive");
                    }
                    
                    // Mark as handled
                    sticker.setAttribute('data-horse-handled', 'true');
                }
            });
            
            // Добавляем обработчики для кнопки паузы
            const pauseButtons = document.querySelectorAll('.pause-button, [class*="pause"], [id*="pause"]');
            pauseButtons.forEach(button => {
                if (!button.hasAttribute('data-horse-handled')) {
                    setupHoverInteraction([button], "this is a separate pause button for the player mode (pause changes to play button and vice versa)");
                    button.setAttribute('data-horse-handled', 'true');
                }
            });
        };

        // Set up sticker interactions
        setupStickerInteractions();

        // Sticker email function
        function sendStickerTextViaAjax(textToSend, inputElement = null) {
            // Check if data is available
            if (typeof stickerEmailData === 'undefined' || !stickerEmailData.ajaxurl || !stickerEmailData.nonce) {
                console.error('Error: Email data not found');
                if (inputElement) inputElement.disabled = false;
                return;
            }

            const data = new FormData();
            data.append("action", "send_sticker_email");
            data.append("user_text", textToSend);
            data.append("security", stickerEmailData.nonce);

            if (inputElement) {
                inputElement.disabled = true;
            }

            fetch(stickerEmailData.ajaxurl, {
                method: "POST",
                body: data,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error: ${response.status}`);
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    updateHorseText("successfully sent", 5000);
                } else {
                    console.error("Send error:", result.data.message);
                    if (inputElement) {
                        inputElement.disabled = false;
                    }
                }
            })
            .catch((error) => {
                console.error("Send error:", error);
                if (inputElement) {
                    inputElement.disabled = false;
                }
            });
        }

        // Add global send function
        window.sendStickerTextViaAjax = sendStickerTextViaAjax;

        // Set up interactions for items next to mirror
        const mirrorItemTexts = [
            "set yourself up for lighting the space",
            "mind your head", 
            "do you know how to listen carefully?",
            "do you know how to follow well? are you a considerate person?"
        ];
        
        const itemsNextToMirror = document.querySelectorAll('.overlay-svg.items-next-to-mirror');
        
        if (itemsNextToMirror.length > 0) {
            itemsNextToMirror.forEach((item, index) => {
                const textIndex = index % mirrorItemTexts.length;
                setupHoverInteraction([item], mirrorItemTexts[textIndex]);
            });
        }

        // Mirror interaction
        setupHoverInteraction(['.mirror', '#mirror-svg-overlay'], "sorry, your reflection is not renderable");

        // Cave room specific interactions
        const caveElementsMap = {
            '#just-cave': "do you feel your body temperature right now?",
            '#walkiephone, .walkiephone, #walkie-phone-in-items-room': "do you know how to listen carefully?",
            '.safety-helmet-img, .safety-helmet, .safety-helmet-f': "mind your head",
            '.fly': "set yourself up for lighting the space",
            '#gbl-speaker-in-items-room': "do you know how to follow well? are you a considerate person?"
        };
        
        // Set up cave interactions
        Object.entries(caveElementsMap).forEach(([selector, text]) => {
            setupHoverInteraction(selector, text);
        });

        // Console room specific interactions
        const consoleElementsMap = {
            '.overlay-svg .skeleton-chair-room': "the ground knows so many steps…",
            '.overlay-svg .table-in-table-room': "I hope this table is adaptive enough for you",
            '#laptop-on-table': "my heart is surrounded by bones. I am able to hear both the heart and the bones. What about you?",
            '.overlay-svg .iphone-camera, .iphone-camera': "this phone doesn't have any secrets and is free for anyone to use",
            '.camera-overlay, .camera': "the motives of this camera are not clear, the date and time are broken",
            '.overlay-svg .window-in-table-room-a3 .no-glow, .overlay-svg .window-in-table-room-a2 .no-glow': "i hear the helicopters and planes behind the window but can't tell whether to expect explosions?",
            '#window-in-table-room': "please, do not leave. I will hide away shortly and you can scroll.",
            '.hard-disk, #hard-disk-on-skeleton-chair': "don't rush to leave, it's a fine day"
        };

        // Set up console interactions
        Object.entries(consoleElementsMap).forEach(([selector, text]) => {
            setupHoverInteraction(selector, text);
        });

        // Добавляем специальный обработчик для 13 кликов по скелету в чердаке
        let skeletonClickCount = 0;
        const centralSkeletonSelector = '.overlay-svg .skeleton-chair-room, #skeleton-chair-room';
        
        document.addEventListener('click', (event) => {
            if (event.target.matches(centralSkeletonSelector) || event.target.closest(centralSkeletonSelector)) {
                skeletonClickCount++;
                
                if (skeletonClickCount === 13) {
                    updateHorseText("the sounds have been stolen by somebody and the moving creatures have been isolated. if you click on the central skeleton in this room 13 times in a row there will be no sound theft and the creatures will synchronize their movements.", 8000);
                    skeletonClickCount = 0; // Сброс счетчика
                } else if (skeletonClickCount < 13) {
                    updateHorseText(`${skeletonClickCount}/13 clicks`, 2000);
                }
            } else {
                // Сброс счетчика если кликнули не по скелету
                skeletonClickCount = 0;
            }
        });

        // Door interactions
        setupHoverInteraction([
            '.overlay-svg[class*="door"]', 
            '.door', 
            '[id*="door"]'
        ], "what do you prefer - closed/open doors or closed/open locks?");

        // Rat interactions
        setupHoverInteraction([
            '.golden-room-door-rats', 
            '.rats', 
            '[class*="rats"]'
        ], "oh no, i am sorry, the mice have escaped the lab!");

        // Lock interactions
        setupClickInteraction([
            '.overlay-svg[class*="lock"]', 
            '.lock', 
            '[id*="lock"]', 
            '[class*="Lock"]'
        ], "do you know how to cipher?");

        // Outside room click interactions
        setupClickInteraction([
            '.overlay-svg[class*="outside"]', 
            '#outside-in-bedroom-room'
        ], "welcome to complete isolation", 5000);

        // Bedroom room interactions
        const setupBedroomInteractions = () => {
            // Bag and Backpack interactions
            const bagItems = [
                { selector: '#bag-in-bedroom, #suitcase-in-bedroom-room', text: "watch out! Is something or someone behind you? are objects also subjects?" },
                { selector: '#backpack-in-bedroom, #backpack-in-bedroom-room', text: "watch out! Is something or someone behind you? are objects also subjects?" }
            ];
            
            bagItems.forEach(item => {
                // Hover interaction
                setupHoverInteraction(item.selector, item.text);
                
                // Click interaction
                setupClickInteraction(item.selector, "press to secure/save/survive");
                
                // Check for associated room
                const roomId = item.selector.split(',')[0].trim().replace('-in-bedroom', '-in-bedroom-room');
                const bagRoom = document.getElementById(roomId.replace('#', ''));
                
                if (bagRoom) {
                    // Add visibility observer only if not already added
                    if (!bagRoom.hasAttribute('data-horse-observed')) {
                        const observer = new MutationObserver((mutations) => {
                            mutations.forEach((mutation) => {
                                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                                    const isActive = bagRoom.style.display !== 'none';
                                    updateHorseText(isActive ? "press to secure/save/survive" : DEFAULT_TEXT);
                                }
                            });
                        });
                        
                        observer.observe(bagRoom, { 
                            attributes: true, 
                            attributeFilter: ['style'] 
                        });
                        
                        bagRoom.setAttribute('data-horse-observed', 'true');
                    }
                }
            });
            
            // Additional bedroom interactions
            setupHoverInteraction('#mirror-svg-overlay', "sorry, your reflection is not renderable");
            setupHoverInteraction('#arrow-right-button', "the numbers on your way are a chance to establish contact with them");
            
            // Silhouette interaction
            setupHoverInteraction('#silhouette', "have you ever been activated? please, check in with your soul. there are many other souls in the walls, it can get confusing.");
            
            // Window interactions
            setupHoverInteraction('#outside-bedroom', "do you know the temperature of air outside someone's window?");
            
            // Outside view interaction
            setupClickInteraction('#outside-in-bedroom-room', "what is your favorite transmission tower? Though let me not distract you for long, I will hide away shortly.");

            // Backpack interaction
            const backpackInBedroom = document.getElementById('backpack-in-bedroom');
            const backpackInBedroomRoom = document.getElementById('backpack-in-bedroom-room');
            
            if (backpackInBedroom && backpackInBedroomRoom) {
                backpackInBedroom.addEventListener('click', () => {
                    updateHorseText("press to secure/save/survive");
                });

                // Optional: Reset text when leaving the backpack room
                const arrowLeftBackpackBedroom = document.getElementById('arrow-left-backpack-bedroom');
                if (arrowLeftBackpackBedroom) {
                    arrowLeftBackpackBedroom.addEventListener('click', () => {
                        updateHorseText("please, select one of my limbs");
                    });
                }
            }

            // Suitcase interaction
            const suitcaseInBedroom = document.getElementById('bag-in-bedroom');
            const suitcaseInBedroomRoom = document.getElementById('suitcase-in-bedroom-room');
            
            if (suitcaseInBedroom && suitcaseInBedroomRoom) {
                suitcaseInBedroom.addEventListener('click', () => {
                    updateHorseText("press to secure/save/survive");
                });

                // Optional: Reset text when leaving the suitcase room
                const arrowLeftSuitcaseBedroom = document.getElementById('arrow-left-suitcase-bedroom');
                if (arrowLeftSuitcaseBedroom) {
                    arrowLeftSuitcaseBedroom.addEventListener('click', () => {
                        updateHorseText("please, select one of my limbs");
                    });
                }
            }

            // Skeleton button interaction
            const skeletonButton = document.getElementById('skeleton-button');
            const skeletonButtonWrapper = document.querySelector('.skeleton-button');
            
            if (skeletonButton && skeletonButtonWrapper) {
                skeletonButton.addEventListener('click', () => {
                    const clickText = skeletonButtonWrapper.getAttribute('data-horse-click');
                    if (clickText) {
                        updateHorseText(clickText);
                    }
                });
            }
        };
        
        // Call the bedroom setup function
        setupBedroomInteractions();

        // Golden Room interactions
        const setupGoldenRoomInteractions = () => {
            const goldenRoomMain = document.getElementById('golden-room-3d');
            
            if (goldenRoomMain && !goldenRoomMain.hasAttribute('data-horse-handled')) {
                // Use event delegation for 3D elements
                goldenRoomMain.addEventListener('mouseover', (event) => {
                    const target = event.target;
                    
                    if (target.classList.contains('door')) {
                        updateHorseText("what do you prefer - closed/open doors or closed/open locks?");
                    } else if (target.classList.contains('rats')) {
                        updateHorseText("oh no, i am sorry, the mice have escaped the lab!");
                    } else if (target.classList.contains('lock')) {
                        updateHorseText("do you know how to cipher?");
                    }
                });
    
                goldenRoomMain.addEventListener('mouseout', () => {
                    updateHorseText(DEFAULT_TEXT);
                });
                
                goldenRoomMain.setAttribute('data-horse-handled', 'true');
            }
            
            // Door rats
            setupClickInteraction('.golden-room-door-rats', "oh no, i am sorry, the mice have escaped the lab!", 5000);
            
            // Door lock
            setupClickInteraction('.golden-room-door-lock', "do you know how to cipher?", 5000);
            
            // Lock overlay
            setupClickInteraction('#LockInLockOverlay', "welcome to complete isolation", 5000);
        };
        
        // Call the golden room setup function
        setupGoldenRoomInteractions();

        // Loading screen interaction
        const loadingScreen = document.getElementById('loadingScreen');
        const loadUpdate = document.getElementById('loadUpdate');
        
        if (loadingScreen && loadUpdate && !loadUpdate.hasAttribute('data-horse-handled')) {
            loadUpdate.addEventListener('DOMSubtreeModified', () => {
                const percentage = parseInt(loadUpdate.textContent);
                if (percentage < 100) {
                    updateHorseText("pixels are in a preparation process. wait for them please. I am sorry if you encounter any bugs.");
                }
            });
            
            loadUpdate.setAttribute('data-horse-handled', 'true');
        }
        
        // Set up a MutationObserver to detect new elements that might need interactions
        const bodyObserver = new MutationObserver((mutations) => {
            let shouldRefreshInteractions = false;
            
            mutations.forEach(mutation => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    // Check if any relevant elements were added
                    for (const node of mutation.addedNodes) {
                        if (node.nodeType === Node.ELEMENT_NODE) {
                            if (
                                node.classList?.contains('overlay-svg') ||
                                node.id?.includes('room') ||
                                node.querySelector?.('.overlay-svg')
                            ) {
                                shouldRefreshInteractions = true;
                                break;
                            }
                        }
                    }
                }
            });
            
            if (shouldRefreshInteractions) {
                log('🔄 New interactive elements detected, refreshing interactions');
                setupStickerInteractions();
                setupBedroomInteractions();
                setupGoldenRoomInteractions();
            }
        });
        
        // Observe the entire document for new elements
        bodyObserver.observe(document.body, { 
            childList: true, 
            subtree: true 
        });
    });
})();

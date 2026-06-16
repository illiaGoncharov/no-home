// 🎛️ CONSOLE TEST SCRIPT - NO HOME Remote Control
// Вставьте этот код в консоль браузера на localhost:8000

console.log('🎛️ Starting Remote Control Console Test...');

// Ждем загрузки
if (typeof window.updateHorseText === 'undefined') {
    console.log('⏳ Waiting for horse text handler...');
    setTimeout(() => {
        if (typeof window.updateHorseText === 'undefined') {
            console.log('❌ Horse Text Handler not loaded!');
        } else {
            runTests();
        }
    }, 2000);
} else {
    runTests();
}

function runTests() {
    console.log('🚀 Running Remote Control Tests...');
    
    const tests = [
        // Основные стикеры
        {
            name: '📄 Sticker Basic',
            selector: '.sticker-img:not(.note8)',
            expected: 'sorry for being weird it\'s my first time being alive',
            type: 'hover'
        },
        {
            name: '✉️ Note8 Email',
            selector: '.note8',
            expected: 'you can leave a note or leave nothing', 
            type: 'hover'
        },
        
        // Скелет
        {
            name: '🦴 Skeleton Button',
            selector: '.skeleton-button',
            expected: 'please, select one of my limbs',
            type: 'click'
        },
        
        // Главная страница
        {
            name: '🪞 Mirror',
            selector: '#mirror-svg-overlay, .mirror',
            expected: 'sorry, your reflection is not renderable',
            type: 'hover'
        },
        {
            name: '🕳️ Cave',
            selector: '#just-cave',
            expected: 'do you feel your body temperature right now?',
            type: 'hover'
        },
        {
            name: '🔦 Flashlight',
            selector: '.fly',
            expected: 'set yourself up for lighting the space',
            type: 'hover'
        },
        {
            name: '🎧 Walkie-talkie',
            selector: '#walkiephone, .walkiephone',
            expected: 'do you know how to listen carefully?',
            type: 'hover'
        },
        {
            name: '⛑️ Safety Helmet',
            selector: '.safety-helmet-img, .safety-helmet',
            expected: 'mind your head',
            type: 'hover'
        },
        {
            name: '🔊 Speaker',
            selector: '#gbl-speaker-in-items-room',
            expected: 'do you know how to follow well? are you a considerate person?',
            type: 'hover'
        },
        
        // Table Room clicks
        {
            name: '☕ Coffee Table',
            selector: '.overlay-svg .skeleton-chair-room',
            expected: 'the ground knows so many steps…',
            type: 'hover'
        },
        {
            name: '🪑 Table',
            selector: '.overlay-svg .table-in-table-room',
            expected: 'I hope this table is adaptive enough for you',
            type: 'hover'
        },
        {
            name: '💻 Laptop',
            selector: '#laptop-on-table',
            expected: 'my heart is surrounded by bones. I am able to hear both the heart and the bones. What about you?',
            type: 'hover'
        },
        {
            name: '📱 iPhone',
            selector: '.overlay-svg .iphone-camera',
            expected: 'this phone doesn\'t have any secrets and is free for anyone to use',
            type: 'hover'
        },
        {
            name: '📷 Camera',
            selector: '.camera-overlay, .camera',
            expected: 'the motives of this camera are not clear, the date and time are broken',
            type: 'hover'
        }
    ];
    
    let results = { passed: 0, failed: 0, total: tests.length };
    
    function testElement(test, index) {
        setTimeout(() => {
            console.log(`🧪 Testing ${index + 1}/${tests.length}: ${test.name}`);
            
            const element = document.querySelector(test.selector);
            if (!element) {
                console.log(`❌ ${test.name}: Element not found (${test.selector})`);
                results.failed++;
                return;
            }
            
            // Store original text
            const originalText = getCurrentHorseText();
            
            // Trigger event
            if (test.type === 'hover') {
                element.dispatchEvent(new MouseEvent('mouseenter', { bubbles: true }));
            } else {
                element.dispatchEvent(new MouseEvent('click', { bubbles: true }));
            }
            
            // Check result
            setTimeout(() => {
                const currentText = getCurrentHorseText();
                if (currentText === test.expected) {
                    console.log(`✅ ${test.name}: PASSED`);
                    results.passed++;
                } else {
                    console.log(`❌ ${test.name}: FAILED`);
                    console.log(`   Expected: "${test.expected}"`);
                    console.log(`   Got: "${currentText}"`);
                    results.failed++;
                }
                
                // Reset text
                if (window.updateHorseText) {
                    window.updateHorseText(originalText);
                }
                
                // Show final results
                if (index === tests.length - 1) {
                    setTimeout(() => {
                        console.log('\n📊 FINAL RESULTS:');
                        console.log(`✅ Passed: ${results.passed}/${results.total}`);
                        console.log(`❌ Failed: ${results.failed}/${results.total}`);
                        console.log(`📈 Success Rate: ${Math.round((results.passed / results.total) * 100)}%`);
                        
                        if (results.failed === 0) {
                            console.log('🎉 ALL TESTS PASSED! Ready for production.');
                        } else {
                            console.log('⚠️ Some tests failed. Check implementation.');
                        }
                    }, 1000);
                }
            }, 300);
        }, index * 1000);
    }
    
    function getCurrentHorseText() {
        const horseTextEl = document.querySelector('#horse-text-original, .horse-indicator-text');
        return horseTextEl ? horseTextEl.textContent.trim() : '';
    }
    
    // Run all tests
    tests.forEach(testElement);
}

console.log('📝 Instructions:');
console.log('1. Open http://localhost:8000 in browser');
console.log('2. Paste this script in console');
console.log('3. Wait for test results');
console.log('4. Only deploy to production if all tests pass!'); 
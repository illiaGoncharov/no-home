// 🏠 MAIN PAGE TEST - NO HOME Remote Control
// Тест только для элементов главной страницы

console.log('🏠 Starting Main Page Test...');

// Ждем загрузки
setTimeout(() => {
    console.log('🚀 Testing Main Page Elements...');
    
    const tests = [
        // Стикеры на главной странице
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
        
        // Скелет (проверим правильный текст)
        {
            name: '🦴 Skeleton Button',
            selector: '.skeleton-button',
            expected: 'please, select one of my limbs',
            type: 'hover'  // Сначала hover, потом click
        }
    ];
    
    let results = { passed: 0, failed: 0, total: tests.length };
    
    function testElement(test, index) {
        setTimeout(() => {
            console.log(`🧪 Testing ${index + 1}/${tests.length}: ${test.name}`);
            
            const element = document.querySelector(test.selector);
            if (!element) {
                console.log(`❌ ${test.name}: Element not found (${test.selector})`);
                console.log('🔍 Available elements:', document.querySelectorAll('.sticker-img, .skeleton-button').length);
                results.failed++;
                return;
            }
            
            console.log(`✅ Element found: ${test.selector}`);
            
            // Store original text
            const originalText = getCurrentHorseText();
            console.log(`📝 Original text: "${originalText}"`);
            
            // Trigger event
            if (test.type === 'hover') {
                element.dispatchEvent(new MouseEvent('mouseenter', { bubbles: true }));
            } else {
                element.dispatchEvent(new MouseEvent('click', { bubbles: true }));
            }
            
            // Check result
            setTimeout(() => {
                const currentText = getCurrentHorseText();
                console.log(`📝 Current text: "${currentText}"`);
                
                if (currentText === test.expected) {
                    console.log(`✅ ${test.name}: PASSED`);
                    results.passed++;
                } else {
                    console.log(`❌ ${test.name}: FAILED`);
                    console.log(`   Expected: "${test.expected}"`);
                    console.log(`   Got: "${currentText}"`);
                    results.failed++;
                }
                
                // Show final results
                if (index === tests.length - 1) {
                    setTimeout(() => {
                        console.log('\n📊 MAIN PAGE RESULTS:');
                        console.log(`✅ Passed: ${results.passed}/${results.total}`);
                        console.log(`❌ Failed: ${results.failed}/${results.total}`);
                        console.log(`📈 Success Rate: ${Math.round((results.passed / results.total) * 100)}%`);
                        
                        if (results.failed === 0) {
                            console.log('🎉 MAIN PAGE TESTS PASSED!');
                        } else {
                            console.log('⚠️ Some main page tests failed.');
                        }
                        
                        // Debug info
                        console.log('\n🔍 DEBUG INFO:');
                        console.log('Available stickers:', document.querySelectorAll('.sticker-img').length);
                        console.log('Skeleton button:', document.querySelector('.skeleton-button') ? 'Found' : 'Not found');
                        console.log('Horse text element:', document.querySelector('#horse-text-original, .horse-indicator-text') ? 'Found' : 'Not found');
                    }, 1000);
                }
            }, 500);
        }, index * 2000);
    }
    
    function getCurrentHorseText() {
        const horseTextEl = document.querySelector('#horse-text-original, .horse-indicator-text');
        return horseTextEl ? horseTextEl.textContent.trim() : '';
    }
    
    // Run all tests
    tests.forEach(testElement);
    
}, 1000);

console.log('📝 Instructions:');
console.log('1. Make sure you are on main page (localhost:8000)');
console.log('2. Paste this script in console');
console.log('3. Wait for test results');
console.log('4. Check preloader is skipped!'); 
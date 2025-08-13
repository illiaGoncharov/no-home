// Remote Control Test Runner
// Запуск: node test-runner.js или в консоли браузера

(function() {
    'use strict';
    
    console.log('🎛️ Remote Control Test Runner Started');
    
    // Test configuration
    const tests = [
        {
            name: 'Sticker Basic',
            selector: '.sticker-img:not(.note8)',
            expected: 'sorry for being weird it\'s my first time being alive',
            event: 'mouseenter'
        },
        {
            name: 'Note8 Email',
            selector: '.note8',
            expected: 'you can leave a note or leave nothing',
            event: 'mouseenter'
        },
        {
            name: 'Mirror',
            selector: '#mirror-svg-overlay',
            expected: 'sorry, your reflection is not renderable',
            event: 'mouseenter'
        },
        {
            name: 'Cave',
            selector: '#just-cave',
            expected: 'do you feel your body temperature right now?',
            event: 'mouseenter'
        },
        {
            name: 'Skeleton Button',
            selector: '.skeleton-button',
            expected: 'please, select one of my limbs',
            event: 'click'
        }
    ];
    
    // Test results
    let results = {
        passed: 0,
        failed: 0,
        total: 0,
        details: []
    };
    
    // Wait for DOM and horse text handler
    function waitForReady() {
        return new Promise((resolve) => {
            if (document.readyState === 'complete' && window.updateHorseText) {
                resolve();
            } else {
                setTimeout(() => waitForReady().then(resolve), 100);
            }
        });
    }
    
    // Run individual test
    function runTest(test) {
        return new Promise((resolve) => {
            console.log(`🧪 Testing: ${test.name}`);
            
            const element = document.querySelector(test.selector);
            if (!element) {
                const result = {
                    name: test.name,
                    passed: false,
                    error: 'Element not found',
                    selector: test.selector
                };
                results.details.push(result);
                results.failed++;
                resolve(result);
                return;
            }
            
            // Store original text
            const originalText = getCurrentHorseText();
            
            // Trigger event
            const event = new Event(test.event, { bubbles: true });
            element.dispatchEvent(event);
            
            // Check result after delay
            setTimeout(() => {
                const currentText = getCurrentHorseText();
                const passed = currentText === test.expected;
                
                const result = {
                    name: test.name,
                    passed: passed,
                    expected: test.expected,
                    actual: currentText,
                    selector: test.selector
                };
                
                results.details.push(result);
                if (passed) {
                    results.passed++;
                    console.log(`✅ ${test.name}: PASSED`);
                } else {
                    results.failed++;
                    console.log(`❌ ${test.name}: FAILED`);
                    console.log(`   Expected: "${test.expected}"`);
                    console.log(`   Got: "${currentText}"`);
                }
                
                // Reset to original text
                if (window.updateHorseText) {
                    window.updateHorseText(originalText);
                }
                
                resolve(result);
            }, 200);
        });
    }
    
    // Get current horse text
    function getCurrentHorseText() {
        const horseTextEl = document.querySelector('#horse-text-original, .horse-indicator-text');
        return horseTextEl ? horseTextEl.textContent.trim() : '';
    }
    
    // Run all tests
    async function runAllTests() {
        console.log('🚀 Starting Remote Control Tests...');
        results = { passed: 0, failed: 0, total: 0, details: [] };
        
        for (const test of tests) {
            await runTest(test);
            results.total++;
            
            // Small delay between tests
            await new Promise(resolve => setTimeout(resolve, 300));
        }
        
        // Print summary
        console.log('\n📊 Test Results Summary:');
        console.log(`✅ Passed: ${results.passed}/${results.total}`);
        console.log(`❌ Failed: ${results.failed}/${results.total}`);
        console.log(`📈 Success Rate: ${Math.round((results.passed / results.total) * 100)}%`);
        
        if (results.failed > 0) {
            console.log('\n💥 Failed Tests:');
            results.details
                .filter(r => !r.passed)
                .forEach(r => {
                    console.log(`- ${r.name}: ${r.error || 'Text mismatch'}`);
                    if (r.expected && r.actual) {
                        console.log(`  Expected: "${r.expected}"`);
                        console.log(`  Got: "${r.actual}"`);
                    }
                });
        }
        
        return results;
    }
    
    // Quick test function
    function quickTest() {
        console.log('⚡ Quick Remote Control Test');
        
        // Test if horse text handler is loaded
        if (!window.updateHorseText) {
            console.log('❌ Horse Text Handler not found!');
            return false;
        }
        
        // Test basic functionality
        const originalText = getCurrentHorseText();
        window.updateHorseText('Test message');
        
        setTimeout(() => {
            const testText = getCurrentHorseText();
            if (testText === 'Test message') {
                console.log('✅ Horse Text Handler working');
                window.updateHorseText(originalText);
            } else {
                console.log('❌ Horse Text Handler not working properly');
            }
        }, 100);
        
        return true;
    }
    
    // Export functions for manual use
    window.remoteControlTests = {
        runAllTests,
        quickTest,
        runTest,
        tests,
        results: () => results
    };
    
    // Auto-run if in test environment
    if (window.location.pathname.includes('/tests/') || window.location.search.includes('test=true')) {
        waitForReady().then(() => {
            console.log('🎯 Auto-running tests...');
            setTimeout(runAllTests, 1000);
        });
    } else {
        console.log('💡 Manual test available: remoteControlTests.runAllTests()');
    }
    
})();

// Quick console commands for manual testing:
console.log(`
🎛️ Remote Control Test Commands:
- remoteControlTests.quickTest()     // Quick functionality test
- remoteControlTests.runAllTests()   // Full test suite
- remoteControlTests.results()       // Show last results
`); 
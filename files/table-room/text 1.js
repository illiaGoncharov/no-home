        const poemElements = [
            document.querySelector('.poem1'),
            document.querySelector('.poem2'),
            document.querySelector('.poem3'),
            document.querySelector('.poem4')
        ];

        let currentPoemIndex = 0;
        const poemElement = document.querySelector('.poem');
        let currentGroup = 0;
        let animationStarted = false;

        function updatePoem() {
            const poemText = poemElements[currentPoemIndex].textContent.trim();
            poemElement.textContent = '';
            currentGroup = 0;
            animateGroup(poemText);
        }

        function animateGroup(poemText) {
            const lines = poemText.trim().split('\n');
            const groupSize = 4;

            if (currentGroup * groupSize >= lines.length) {
                currentGroup = 0;
            }

            poemElement.innerHTML = '';
            let totalCharacters = 0;

            for (let i = currentGroup * groupSize; i < (currentGroup + 1) * groupSize && i < lines.length; i++) {
                const line = lines[i];
                const characters = line.split('');
                characters.forEach((char, charIndex) => {
                    const span = document.createElement('span');
                    span.textContent = char === ' ' ? '\u00A0' : char;
                    span.style.opacity = '0';
                    span.style.animation = `fadeIn 0.5s forwards ${totalCharacters * 0.05}s`;
                    poemElement.appendChild(span);
                    totalCharacters++;
                });
                if (i < lines.length - 1) {
                    poemElement.appendChild(document.createElement('br'));
                }
            }

            setTimeout(() => {
                const spans = poemElement.querySelectorAll('span');
                spans.forEach((span, index) => {
                    span.style.animation = `fadeIn 0.5s forwards, fadeOut 0.5s forwards ${totalCharacters * 0.05 + 2 + index * 0.05}s`;
                });

                setTimeout(() => {
                    currentGroup++;
                    animateGroup(poemText);
                }, (totalCharacters * 0.05 + 2 + spans.length * 0.05 + 0.5) * 1000);
            }, totalCharacters * 50 + 100);
        }

        poemElement.addEventListener('click', () => {
            currentPoemIndex = (currentPoemIndex + 1) % poemElements.length;
            updatePoem();
        });

        // Three.js smoke effect
        let scene, camera, renderer, smokeParticles = [];

        function initSmoke() {
            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 10000);
            camera.position.z = 1000;
            renderer = new THREE.WebGLRenderer({
                canvas: document.getElementById('smokeCanvas'),
                alpha: true
            });
            renderer.setSize(window.innerWidth, window.innerHeight);

            const light = new THREE.DirectionalLight(0xffffff, 0.5);
            light.position.set(-1, 0, 1);
            scene.add(light);

            const smokeTexture = new THREE.TextureLoader().load('https://s3-us-west-2.amazonaws.com/s.cdpn.io/95637/Smoke-Element.png');
            const smokeMaterial = new THREE.MeshLambertMaterial({
                color: 0xffffff,
                map: smokeTexture,
                transparent: true
            });
            const smokeGeo = new THREE.PlaneGeometry(300, 300);

            for (let p = 0; p < 150; p++) {
                const particle = new THREE.Mesh(smokeGeo, smokeMaterial);
                particle.position.set(
                    Math.random() * 500 - 250,
                    Math.random() * 500 - 250,
                    Math.random() * 1000 - 100
                );
                particle.rotation.z = Math.random() * 360;
                scene.add(particle);
                smokeParticles.push(particle);
            }

            animate();
        }

        function animate() {
            requestAnimationFrame(animate);
            smokeParticles.forEach(particle => {
                particle.rotation.z += 0.001;
            });
            renderer.render(scene, camera);
        }

        initSmoke();

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // Наблюдатель за изменением стиля элемента
        const targetNode = document.getElementById('window-in-table-room');
        const config = { attributes: true, attributeFilter: ['style'] };

        const callback = function(mutationsList, observer) {
            for(let mutation of mutationsList) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    if (targetNode.style.display === 'block' && !animationStarted) {
                        animationStarted = true;
                        updatePoem();
                    }
                }
            }
        };

        const observer = new MutationObserver(callback);
        observer.observe(targetNode, config);
function initializePoem() {
    const poems = {
        poem1: `the range of emotions is limited
the range of reactions is limited 
i do not choose the feeling 
my maximum 
is the capacity to correct 
the internal reaction to the feeling 
is the capacity to correct
the cognitive reaction to the feeling 
the feeling provoked by the thought
provoked by contacting the matter 
provoked by the contingency of thought and matter 
the boundary of the internal 
the boundary of the external 
boundary + boundary + boundary + boundary 
languages 
signifying 
signifies 
imaginable 
feelable 
what about not remembering? 
when I believe in the power of my reaction 
I always discover something 
but I don't always recognise it right`,
        poem2: `your grid has more eyes 
your grid has more fingers 
your grid has more abrasions
your screen in the screens of others 
fap_fap_fap
scrrrrr***olllll
your anxiety looks like 
a small picture of a heart 
your signals are choreographed pixels 
"a realistic perspective" ≠ real perspective 
your room is a validated isolator 
but you don't have one
and – and – and 
dis-identification
leave and come back in properly 
computer logic 
unrealistic perspective`,
        poem4: `Temporary stay 
In culture 
In law 
In the norm 
In breaching
In understanding 
In language 
I try to hear an explosion both here and there 
When I only heard it from the screen 
Temporary stay 
In the screen 
The power of knowledge or the lack of 
The power of understanding or the lack of 
The power of interest 
The power of emptiness 
The power of pain 
The power of security 
Bam + Bam + Bam + Bam + Bam + Bam 
Panic attack 
A new pill dissolves inside of me 
Thirst for clean water`
    };

    let currentPoemKey = 'poem1';
    let poemElement;
    let currentGroup = 0;
    let animationStarted = false;
    let animationTimeout;

    function animateGroup() {
        const poemText = poems[currentPoemKey];
        const lines = poemText.trim().split('\n');
        const groupSize = 4;

        if (currentGroup * groupSize >= lines.length) {
            currentGroup = 0;
        }

        poemElement.innerHTML = '';
        let totalDelay = 0;
        const lineDelay = 1000;
        const charDelay = 50;

        for (let i = currentGroup * groupSize; i < (currentGroup + 1) * groupSize && i < lines.length; i++) {
            const line = lines[i];
            const lineElement = document.createElement('div');
            poemElement.appendChild(lineElement);

            line.split('').forEach((char, charIndex) => {
                const span = document.createElement('span');
                span.textContent = char === ' ' ? '\u00A0' : char;
                span.style.opacity = '0';
                span.style.animation = `fadeIn 0.5s forwards ${totalDelay + charIndex * charDelay}ms`;
                lineElement.appendChild(span);
            });

            totalDelay += lineDelay;
        }

        const appearanceDuration = totalDelay + lineDelay;
        const displayDuration = 100;

        animationTimeout = setTimeout(() => {
            const spans = poemElement.querySelectorAll('span');
            spans.forEach((span, index) => {
                span.style.animation += `, fadeOut 1s forwards ${appearanceDuration + displayDuration + index * 10}ms`;
            });

            currentGroup++;

            animationTimeout = setTimeout(animateGroup, appearanceDuration + displayDuration + spans.length * 10 + 10);
        }, appearanceDuration + displayDuration);
    }

    function startAnimation() {
        if (!animationStarted) {
            animationStarted = true;
            animateGroup();
        }
    }

    function stopAnimation() {
        if (animationStarted) {
            animationStarted = false;
            clearTimeout(animationTimeout);
            poemElement.innerHTML = '';
            currentGroup = 0;
        }
    }

    function changePoem() {
        const poemKeys = Object.keys(poems);
        const currentIndex = poemKeys.indexOf(currentPoemKey);
        currentPoemKey = poemKeys[(currentIndex + 1) % poemKeys.length];
        currentGroup = 0;
        if (animationStarted) {
            stopAnimation();
            startAnimation();
        }
    }

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

        const yOffset = window.innerHeight * 0.27; // 10% от высоты экрана

        for (let p = 0; p < 150; p++) {
            const particle = new THREE.Mesh(smokeGeo, smokeMaterial);
            particle.position.set(
                Math.random() * 500 - 250,
                Math.random() * 500 - 250 + yOffset, // Добавляем смещение по Y
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

    function init() {
        poemElement = document.getElementById('currentPoem');
        poemElement.addEventListener('click', changePoem);

        initSmoke();

        startAnimation();
    }

    window.addEventListener('load', init);

    window.addEventListener('resize', () => {
    if (camera) { // Check if the camera is defined
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    }
    });
}

// Call the initializePoem function to start the animation
initializePoem();
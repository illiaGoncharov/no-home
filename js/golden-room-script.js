    import * as THREE from 'https://nohome.cloud/three.js-master/build/three.module.js';
    import { GLTFLoader } from 'https://nohome.cloud/three.js-master/examples/jsm/loaders/GLTFLoader.js';
    import { DRACOLoader } from 'https://nohome.cloud/three.js-master/examples/jsm/loaders/DRACOLoader.js';
    import { OrbitControls } from 'https://nohome.cloud/three.js-master/examples/jsm/controls/OrbitControls.js';
    import { EffectComposer } from 'https://nohome.cloud/three.js-master/examples/jsm/postprocessing/EffectComposer.js';
    import { RenderPass } from 'https://nohome.cloud/three.js-master/examples/jsm/postprocessing/RenderPass.js';
    import { OutlinePass } from 'https://nohome.cloud/three.js-master/examples/jsm/postprocessing/OutlinePass.js';
    import { ShaderPass } from 'https://nohome.cloud/three.js-master/examples/jsm/postprocessing/ShaderPass.js';
    import { GammaCorrectionShader } from 'https://nohome.cloud/three.js-master/examples/jsm/shaders/GammaCorrectionShader.js';

    let scene, camera, renderer, room, controls, composer, outlinePass;
    let raycaster = new THREE.Raycaster();
    let mouse = new THREE.Vector2();
    let selectedObject = null;
    let clickStartObject = null;

    const Doors = ["Door_low", "Door_low_1", "Door_low_2", "Door_low_3"];
    const Rats = ["Mesh_0", "Mesh_1", "Mesh_2", "Mesh_3", "Mesh_4", "Mesh_5", "Mesh_6", "Mesh_7", "Mesh_8", "Mesh_9"];
    const Lock1 = ["defaultMaterial", "Boole", "Cube_2"];
    const Lock2 = ["defaultMaterial_3", "Boole_3", "Cube_4"];
    const Lock3 = ["chain", "Cube"];
    const Lock4 = ["defaultMaterial_2", "Boole_2", "Cube_3"];

    init();
    animate();

    function init() {
        scene = new THREE.Scene();
        camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.set(0.84, 0.13 , -0.83);
        camera.lookAt(new THREE.Vector3(-0.7, -0.11, 0.7));
        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.physicallyCorrectLights = true; // Включение физически корректного освещения
        renderer.outputEncoding = THREE.sRGBEncoding; // Использование sRGB кодировки

        const dracoLoader = new DRACOLoader();
        dracoLoader.setDecoderPath('https://unpkg.com/three@0.166.0/examples/jsm/libs/draco/gltf/');
        dracoLoader.setDecoderConfig({ type: 'js' });

        const loader = new GLTFLoader();
        loader.setDRACOLoader(dracoLoader);

        let lastLoggedPercentage = 0;
        const totalSizeInMB = 80;

        loader.load(
            'https://nohome.cloud/wp-content/themes/NOHOME/files/golden-room/Compressed_GR1.glb',
            function (gltf) {
                room = gltf.scene;
                room.scale.set(1, 1, 1);
                room.position.set(0, -1.5, 0);
                scene.add(room);
                document.getElementById('golden-room-3d').appendChild(renderer.domElement);
                document.getElementById('loadingScreen').style.display = 'none';
            },
            function (xhr) {
                const loadedMB = (xhr.loaded / 1024 / 1024).toFixed(2);
                const percentage = Math.floor((loadedMB / totalSizeInMB) * 100);

                if (percentage > lastLoggedPercentage) {
                    document.getElementById('loadingProgress').textContent = `${percentage}% loaded`;
                    lastLoggedPercentage = percentage;
                }
            },
            function (error) {
                console.error('An error happened', error);
            }
        );

        controls = new OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.25;
        controls.enablePan = false;
        controls.minDistance = 0.1;
        controls.maxDistance = 6;
        controls.maxPolarAngle = Math.PI;

        composer = new EffectComposer(renderer);
        composer.setSize(window.innerWidth, window.innerHeight);

        const renderPass = new RenderPass(scene, camera);
        composer.addPass(renderPass);

        outlinePass = new OutlinePass(new THREE.Vector2(window.innerWidth, window.innerHeight), scene, camera);
        outlinePass.edgeStrength = 9;
        outlinePass.edgeGlow = 0;
        outlinePass.edgeThickness = 5;
        outlinePass.pulsePeriod = 1;
        composer.addPass(outlinePass);

        const gammaCorrectionPass = new ShaderPass(GammaCorrectionShader);
        composer.addPass(gammaCorrectionPass);

        window.addEventListener('resize', onWindowResize, false);
        renderer.domElement.addEventListener('mousemove', onMouseMove, false);
        renderer.domElement.addEventListener('mousedown', onMouseDown, false);
        renderer.domElement.addEventListener('mouseup', onMouseUp, false);
    }

    function onMouseMove(event) {
        event.preventDefault();

        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);

        if (room) {
            let intersects = raycaster.intersectObjects(room.children, true);

            if (intersects.length > 0) {
                let firstIntersected = intersects[0].object;
                if (Doors.includes(firstIntersected.name)) {
                    outlinePass.selectedObjects = [firstIntersected];
                    selectedObject = firstIntersected;
                } else if (Rats.includes(firstIntersected.name)) {
                    outlinePass.selectedObjects = [firstIntersected];
                    selectedObject = firstIntersected;
                } else if (Lock1.includes(firstIntersected.name)) {
                    let lockObjects = [];
                    room.traverse(function (child) {
                        if (Lock1.includes(child.name)) {
                            lockObjects.push(child);
                        }
                    });
                    outlinePass.selectedObjects = lockObjects;
                    selectedObject = firstIntersected;
                } else if (Lock2.includes(firstIntersected.name)) {
                    let lockObjects = [];
                    room.traverse(function (child) {
                        if (Lock2.includes(child.name)) {
                            lockObjects.push(child);
                        }
                    });
                    outlinePass.selectedObjects = lockObjects;
                    selectedObject = firstIntersected;
                } else if (Lock3.includes(firstIntersected.name)) {
                    let lockObjects = [];
                    room.traverse(function (child) {
                        if (Lock3.includes(child.name)) {
                            lockObjects.push(child);
                        }
                    });
                    outlinePass.selectedObjects = lockObjects;
                    selectedObject = firstIntersected;
                } else if (Lock4.includes(firstIntersected.name)) {
                    let lockObjects = [];
                    room.traverse(function (child) {
                        if (Lock4.includes(child.name)) {
                            lockObjects.push(child);
                        }
                    });
                    outlinePass.selectedObjects = lockObjects;
                    selectedObject = firstIntersected;
                } else {
                    outlinePass.selectedObjects = [];
                    selectedObject = null;
                }
            } else {
                outlinePass.selectedObjects = [];
                selectedObject = null;
            }
        }
    }

    function onMouseDown(event) {
        event.preventDefault();

        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);

        if (room) {
            let intersects = raycaster.intersectObjects(room.children, true);

            if (intersects.length > 0) {
                clickStartObject = intersects[0].object;
            }
        }
    }

    function onMouseUp(event) {
        event.preventDefault();

        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);

        if (room) {
    let intersects = raycaster.intersectObjects(room.children, true);
    if (intersects.length > 0) {
        let clickEndObject = intersects[0].object;
        if (clickStartObject === clickEndObject) {
            if (Doors.includes(clickEndObject.name)) {
                console.log('Door clicked');
                let doorSound = document.getElementById('doorSound');
                doorSound.play();
                

                // Wait for animation and sound, then navigate
                setTimeout(() => {
        // Hide the element with id="golden-room-3d"
        let goldenRoom3D = document.getElementById('golden-room-3d');
        if (goldenRoom3D) {
            goldenRoom3D.style.display = 'none'; // Or another method to hide it
        }

        // Show the element with id="golden-room-door"
        let goldenRoomDoor = document.getElementById('golden-room-door');
        if (goldenRoomDoor) {
            goldenRoomDoor.style.display = 'block'; // Or another method to make it visible
        }
                }, 750); // 750ms = 3/4 second
            } else if (Rats.includes(clickEndObject.name)) {
                console.log('Mouse clicked');
                ratSound.play();
            } else if (Lock1.includes(clickEndObject.name) || 
                       Lock2.includes(clickEndObject.name) || 
                       Lock3.includes(clickEndObject.name) || 
                       Lock4.includes(clickEndObject.name)) {
                console.log('Lock clicked');
                doorLockSound.play();
            }
        }
    }
}

        clickStartObject = null;
    }

    function onWindowResize() {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
        composer.setSize(window.innerWidth, window.innerHeight);
    }

    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        composer.render();
//logCameraPosition();
    }

function logCameraPosition() {
    const cameraPosition = camera.position;
    const cameraLookAt = new THREE.Vector3();
    camera.getWorldDirection(cameraLookAt);

//    console.log(`Camera Position: x=${cameraPosition.x}, y=${cameraPosition.y}, //z=${cameraPosition.z}`);
//    console.log(`Camera LookAt: x=${cameraLookAt.x}, y=${cameraLookAt.y}, z=${cameraLookAt.z}`);
}

    function animateCameraTransition(startPosition, startLookAt, endPosition, endLookAt, duration) {
        const startTime = performance.now();
        
        function animate() {
            const elapsed = performance.now() - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Интерполяция позиции камеры
            camera.position.lerpVectors(startPosition, endPosition, progress);
            
            // Интерполяция направления взгляда камеры
            const interpolatedLookAt = new THREE.Vector3().lerpVectors(startLookAt, endLookAt, progress);
            camera.lookAt(interpolatedLookAt);

            composer.render();  // Обновите рендеринг сцены с новым состоянием камеры

            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        }

        animate();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var loadingScreen = document.getElementById('loadingScreen');
        document.body.appendChild(loadingScreen);
    });
@extends('layouts.app')

@section('content')
    <!-- ESTILOS -->
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">

    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- THREE JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>

    <style>
        body {
            background-color: #0b0f19 !important;
            color: #ffffff;
            overflow-x: hidden;
        }

        html {
            background-color: #0b0f19 !important;
        }

        .studio-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 30px;
            box-sizing: border-box;
        }

        .studio-grid {
            display: grid;
            grid-template-columns: 1fr 1.3fr;
            gap: 50px;
            margin-top: 30px;
            width: 100%;
        }

        @media (max-width: 992px) {
            .studio-grid {
                grid-template-columns: 1fr;
            }
        }

        .ai-control-panel {
            background: rgba(22, 30, 49, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .panel-section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #4f46e5;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group-studio {
            margin-bottom: 20px;
        }

        .form-group-studio label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        .select-studio {
            width: 100%;
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            border-radius: 8px !important;
            padding: 12px !important;
            color: #ffffff !important;
            font-size: 14px;
            box-sizing: border-box;
        }

        .textarea-studio {
            width: 100%;
            background-color: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 12px;
            color: #ffffff;
            font-size: 14px;
            resize: none;
            height: 100px;
            box-sizing: border-box;
        }

        .avatar-3d-viewport {
            background: radial-gradient(circle at center, #1e1b4b 0%, #090d16 100%);
            border: 1px solid rgba(79, 70, 229, 0.3);
            border-radius: 16px;
            height: 650px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        #threeCanvas {
            width: 100%;
            height: 100%;
            display: block;
        }

        .laser-scanner-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right,
                    transparent,
                    #38bdf8,
                    #4f46e5,
                    #38bdf8,
                    transparent);
            box-shadow: 0 0 15px #38bdf8, 0 0 30px #4f46e5;
            z-index: 3;
            animation: scanMove 4s linear infinite;
        }

        @keyframes scanMove {
            0% {
                top: 0%;
                opacity: 0;
            }

            5% {
                opacity: 1;
            }

            95% {
                opacity: 1;
            }

            100% {
                top: 100%;
                opacity: 0;
            }
        }

        .viewport-overlay-controls {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 5;
            width: 85%;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-display {
            font-size: 24px;
            font-weight: 800;
            color: #38bdf8;
        }

        .btn-studio-generate {
            background-color: #4f46e5 !important;
            border: none !important;
            color: white !important;
            width: 100%;
            padding: 14px !important;
            border-radius: 8px !important;
            font-weight: 700 !important;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
            transition: 0.2s;
        }

        .btn-studio-generate:hover {
            background-color: #4338ca !important;
        }

        .btn-studio-checkout {
            background-color: #22c55e !important;
            border: none !important;
            color: white !important;
            padding: 12px 24px !important;
            border-radius: 8px !important;
            font-weight: 700 !important;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-studio-checkout:hover {
            background-color: #16a34a !important;
        }

        .ai-loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(11, 15, 25, 0.95);
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        .ai-loading-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .sparkle-spinner {
            font-size: 50px;
            color: #38bdf8;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="studio-container">

        <!-- HEADER -->
        <div class="catalog-header-section"
            style="padding: 20px 0; display: flex; justify-content: space-between; align-items: center;">

            <div class="catalog-title">
                <h1>AI Design Studio — StyleMe</h1>
                <p>Crea diseños IA en una camiseta 3D interactiva</p>
            </div>

            <div>
                <button class="btn-view-cart" onclick="verCarrito()"
                    style="
                    background-color: #4f46e5;
                    border: none;
                    color: white;
                    padding: 12px 24px;
                    border-radius: 30px;
                    font-weight: 700;
                ">
                    <i class="fas fa-shopping-bag"></i>
                    Ver Carrito

                    <span class="badge bg-danger text-white ms-1" id="carritoCantidad">0</span>
                </button>
            </div>
        </div>

        <div class="studio-grid">

            <!-- PANEL -->
            <div class="ai-control-panel">

                <div class="panel-section-title">
                    <i class="fas fa-wand-magic-sparkles"></i>
                    Generación IA
                </div>

                <div class="form-group-studio">
                    <label>Describe el estampado</label>

                    <textarea id="prompt" class="textarea-studio" placeholder="Ej. Dragon Ball Android 17 anime style"></textarea>
                </div>

                <div class="form-group-studio">
                    <label>Tipo de Prenda</label>

                    <select id="tipo_camisa" class="select-studio">

                        <option value="premium cotton t-shirt">
                            Camisa Premium
                        </option>

                        {{-- <option value="oversized streetwear t-shirt">
                            Oversized
                        </option> --}}

                        <option value="black hoodie">
                            Hoodie
                        </option>

                    </select>
                    <div class="form-group-studio">
                        <label>Color de Prenda</label>

                        <select id="color_camisa" class="select-studio">

                            <option value="#111111">
                                Negro
                            </option>

                            <option value="#ffffff">
                                Blanco
                            </option>

                            <option value="#dc2626">
                                Rojo
                            </option>

                            <option value="#2563eb">
                                Azul
                            </option>

                            <option value="#16a34a">
                                Verde
                            </option>

                        </select>
                    </div>
                </div>

                <div class="form-group-studio">
                    <label>Talla</label>

                    <select id="talla" class="select-studio">

                        <option>S</option>
                        <option selected>M</option>
                        <option>L</option>
                        <option>XL</option>

                    </select>
                </div>

                <button class="btn-studio-generate" onclick="simularGeneracionIA()">

                    <i class="fas fa-arrows-spin"></i>

                    Generar Diseño

                </button>

            </div>

            <!-- VISOR -->
            <div class="avatar-3d-viewport">

                <div class="laser-scanner-line"></div>

                <!-- LOADING -->
                <div class="ai-loading-overlay" id="loadingAi">

                    <i class="fas fa-circle-notch sparkle-spinner"></i>

                    <h5 class="mt-4">
                        Generando diseño IA...
                    </h5>

                </div>

                <!-- CANVAS -->
                <canvas id="threeCanvas"></canvas>

                <!-- CONTROLES -->
                <div class="viewport-overlay-controls">

                    <div>
                        <div style="font-size: 11px; color: #94a3b8;">
                            Precio
                        </div>

                        <div class="price-display">
                            $35.00
                        </div>
                    </div>

                    <div style="display:flex; align-items:center; gap:12px;">

                        <input type="number" id="cantidad_prendas" value="1" min="1" max="99"
                            style="
                            width:60px;
                            height:42px;
                            background:#1e293b;
                            border:1px solid #334155;
                            color:white;
                            border-radius:8px;
                            text-align:center;
                        ">

                        <button class="btn-studio-checkout" onclick="agregarDisenoAlCarrito()">

                            <i class="fas fa-cart-plus"></i>

                            Añadir

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        async function fallbackHF(prompt) {

            const response = await fetch(
                "https://api-inference.huggingface.co/models/stabilityai/stable-diffusion-xl-base-1.0", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        inputs: prompt
                    })
                }
            );

            if (!response.ok) throw new Error("HF falló");

            const blob = await response.blob();

            return URL.createObjectURL(blob);
        }
        let scene;
        let camera;
        let renderer;
        let controls;

        let shirtModel = null;

        let designPlane = null;

        let estampadoY = 0.3;
        let estampadoZ = 0.13;

        let modelRotationX = 0;
        let modelRotationY = 0;
        let modelRotationZ = 0;

        var productosSeleccionados =
            JSON.parse(localStorage.getItem('carrito')) || [];

        function detectarCategoria(prompt) {

            const p = prompt.toLowerCase();

            if (p.includes("goku") || p.includes("anime") || p.includes("naruto") || p.includes("luffy")) {
                return "anime";
            }

            if (p.includes("carro") || p.includes("auto") || p.includes("bmw") || p.includes("car")) {
                return "cars";
            }

            if (p.includes("ciudad") || p.includes("city") || p.includes("edificio") || p.includes("street")) {
                return "city";
            }

            if (p.includes("hoodie") || p.includes("shirt") || p.includes("camisa")) {
                return "clothing";
            }

            return "random";
        }

        const imageBank = {
            anime: [
                "https://picsum.photos/768/768?random=11",
                "https://picsum.photos/768/768?random=12",
                "https://picsum.photos/768/768?random=13"
            ],

            cars: [
                "https://picsum.photos/768/768?random=21",
                "https://picsum.photos/768/768?random=22",
                "https://picsum.photos/768/768?random=23"
            ],

            city: [
                "https://picsum.photos/768/768?random=31",
                "https://picsum.photos/768/768?random=32",
                "https://picsum.photos/768/768?random=33"
            ],

            clothing: [
                "https://picsum.photos/768/768?random=41",
                "https://picsum.photos/768/768?random=42",
                "https://picsum.photos/768/768?random=43"
            ],

            random: [
                "https://picsum.photos/768/768?random=100",
                "https://picsum.photos/768/768?random=200"
            ]
        };

        init3D();

        function init3D() {

            const canvas =
                document.getElementById('threeCanvas');

            // ESCENA
            scene =
                new THREE.Scene();

            // CAMARA
            camera =
                new THREE.PerspectiveCamera(
                    45,
                    canvas.clientWidth / canvas.clientHeight,
                    0.1,
                    1000
                );

            camera.position.set(
                0,
                1,
                5
            );

            // RENDER
            renderer =
                new THREE.WebGLRenderer({
                    canvas: canvas,
                    antialias: true,
                    alpha: true
                });

            renderer.setSize(
                canvas.clientWidth,
                canvas.clientHeight
            );

            renderer.setPixelRatio(
                window.devicePixelRatio
            );

            renderer.outputEncoding =
                THREE.sRGBEncoding;

            // CONTROLES
            controls =
                new THREE.OrbitControls(
                    camera,
                    renderer.domElement
                );

            controls.enableDamping = true;

            controls.enableZoom = true;

            controls.minDistance = 2;

            controls.maxDistance = 7;

            // AUTO ROTATE
            // controls.autoRotate = true;

            // controls.autoRotateSpeed = 1;

            // LUCES
            const ambientLight =
                new THREE.AmbientLight(
                    0xffffff,
                    1.2
                );

            scene.add(ambientLight);

            const directionalLight =
                new THREE.DirectionalLight(
                    0xffffff,
                    1.2
                );

            directionalLight.position.set(
                5,
                10,
                7
            );

            scene.add(directionalLight);

            // CARGAR MODELO
            cargarModelo();

            animate();

            // CAMBIO DE PRENDA
            document.getElementById('tipo_camisa')
                .addEventListener(
                    'change',
                    cargarModelo
                );

            // CAMBIO COLOR
            document.getElementById('color_camisa')
                .addEventListener(
                    'change',
                    aplicarColorModelo
                );

            // RESPONSIVE
            window.addEventListener(
                'resize',
                onWindowResize
            );
        }

        function cargarModelo() {

            const tipo =
                document.getElementById('tipo_camisa').value;

            let modelPath = '';

            let modelScale = 4;

            let modelY = -1.5;

            let modelX = 0;
            let modelZ = 0;

            // CONFIGURACIONES
            if (tipo === 'premium cotton t-shirt') {

                modelPath = '/models/tshirt.glb';

                // TAMAÑO
                modelScale = 4;

                // POSICIÓN
                modelX = 0.04;
                modelY = -5;
                modelZ = 0;

                // ROTACIONES
                modelRotationX = 0.19;

                modelRotationY = 0.5;

                modelRotationZ = -0.04;

                // ESTAMPADO
                estampadoY = 0.6;

                estampadoZ = 1;

            } else {

                modelPath = '/models/hoodie.glb';

                // TAMAÑO
                modelScale = 4.5;

                // POSICIÓN
                modelX = 0;
                modelY = -4.6;
                modelZ = 0;

                // ROTACIONES
                modelRotationX = 0.02;

                modelRotationY = 0;

                modelRotationZ = 0;

                // ESTAMPADO
                estampadoY = 0.6;

                estampadoZ = 0.7;
            }

            // ELIMINAR MODELO ANTERIOR
            if (shirtModel) {

                scene.remove(shirtModel);
            }

            // ELIMINAR ESTAMPADO
            if (designPlane) {

                scene.remove(designPlane);
            }

            const loader =
                new THREE.GLTFLoader();

            loader.load(

                modelPath,

                function(gltf) {

                    shirtModel =
                        gltf.scene;

                    // ESCALA
                    shirtModel.scale.set(
                        modelScale,
                        modelScale,
                        modelScale
                    );

                    // POSICION
                    shirtModel.position.set(
                        modelX,
                        modelY,
                        modelZ
                    );

                    // ROTACION
                    shirtModel.rotation.set(
                        modelRotationX,
                        modelRotationY,
                        modelRotationZ
                    );

                    // MATERIALES
                    shirtModel.traverse(function(child) {

                        if (child.isMesh) {

                            child.material =
                                new THREE.MeshStandardMaterial({

                                    color: document.getElementById('color_camisa').value,

                                    roughness: 0.8,

                                    metalness: 0.1
                                });

                            child.castShadow = true;

                            child.receiveShadow = true;
                        }
                    });

                    scene.add(shirtModel);
                },

                undefined,

                function(error) {

                    console.log(error);

                    Swal.fire(
                        'Error',
                        'No se pudo cargar el modelo 3D',
                        'error'
                    );
                }
            );
        }

        function aplicarColorModelo() {

            if (!shirtModel) return;

            const color =
                document.getElementById('color_camisa').value;

            shirtModel.traverse(function(child) {

                if (child.isMesh) {

                    child.material.color.set(color);
                }
            });
        }

        function onWindowResize() {

            const canvas =
                document.getElementById('threeCanvas');

            camera.aspect =
                canvas.clientWidth / canvas.clientHeight;

            camera.updateProjectionMatrix();

            renderer.setSize(
                canvas.clientWidth,
                canvas.clientHeight
            );
        }

        function animate() {

            requestAnimationFrame(animate);

            controls.update();

            renderer.render(
                scene,
                camera
            );
        }

        async function simularGeneracionIA() {

            const promptInput = document.getElementById('prompt').value;

            if (!promptInput.trim()) {
                Swal.fire('Diseño IA', 'Escribe un diseño.', 'info');
                return;
            }

            const loading = document.getElementById('loadingAi');
            loading.classList.add('active');

            await new Promise(r => setTimeout(r, 1500));

            const categoria = detectarCategoria(promptInput);

            const lista = imageBank[categoria] || imageBank.random;

            const url = lista[Math.floor(Math.random() * lista.length)];

            const img = new Image();
            img.crossOrigin = "anonymous";
            img.src = url;

            img.onload = () => {
                procesarImagen(img, loading);
            };

            img.onerror = () => {
                loading.classList.remove('active');
                Swal.fire('Error', 'No se pudo generar imagen', 'error');
            };
        }

        function procesarImagen(img, loading) {

            const canvasTexture = document.createElement('canvas');

            canvasTexture.width = img.width;
            canvasTexture.height = img.height;

            const ctx = canvasTexture.getContext('2d');

            ctx.drawImage(img, 0, 0);

            const texture = new THREE.CanvasTexture(canvasTexture);

            texture.needsUpdate = true;
            texture.minFilter = THREE.LinearFilter;
            texture.magFilter = THREE.LinearFilter;

            const designGeometry = new THREE.PlaneGeometry(1, 1);

            const designMaterial = new THREE.MeshBasicMaterial({
                map: texture,
                transparent: true
            });

            if (designPlane) scene.remove(designPlane);

            designPlane = new THREE.Mesh(designGeometry, designMaterial);

            designPlane.position.set(0, estampadoY, estampadoZ);

            scene.add(designPlane);

            window.generatedDesign = canvasTexture.toDataURL("image/png");

            loading.classList.remove('active');

            Swal.fire({
                icon: 'success',
                title: 'Diseño generado',
                timer: 2000,
                showConfirmButton: false
            });
        }

        function agregarDisenoAlCarrito() {

            var prompt =
                document.getElementById('prompt').value;

            var tipoPrenda =
                document.getElementById('tipo_camisa').value;

            var talla =
                document.getElementById('talla').value;

            var color =
                document.getElementById('color_camisa').value;

            var cantidad =
                parseInt(
                    document.getElementById('cantidad_prendas').value
                );

            if (!window.generatedDesign) {

                Swal.fire(
                    'Diseño IA',
                    'Primero genera un diseño.',
                    'warning'
                );

                return;
            }

            var itemDiseno = {

                id: Date.now(),

                nombre: "Diseño IA",

                tipoPrenda: tipoPrenda,

                talla: talla,

                color: color,

                precio: 35.00,

                cantidad: cantidad,

                imagen: window.generatedDesign,

                prompt: prompt
            };

            productosSeleccionados.push(
                itemDiseno
            );

            localStorage.setItem(
                'carrito',
                JSON.stringify(productosSeleccionados)
            );

            actualizarCantidadCarrito();

            Swal.fire({
                icon: 'success',
                title: 'Agregado al carrito',
                timer: 1800,
                showConfirmButton: false
            });
        }

        function actualizarCantidadCarrito() {

            var carrito =
                JSON.parse(
                    localStorage.getItem('carrito')
                ) || [];

            var total = 0;

            carrito.forEach(function(item) {

                total += item.cantidad;
            });

            document.getElementById(
                'carritoCantidad'
            ).textContent = total;
        }

        function verCarrito() {

            window.location.href =
                '{{ route('checkout') }}';
        }

        actualizarCantidadCarrito();
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/homeuser.css') }}">

    <style>
        /* Contenedor central premium */
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
            box-sizing: border-box;
        }

        /* Tarjeta de perfil superior estilizada */
        .profile-status-card {
            background: rgba(22, 30, 49, 0.7) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-status-card h4 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #ffffff;
        }

        .profile-status-card p {
            color: #94a3b8;
            font-size: 14px;
            margin: 0;
        }

        /* Mensaje principal de bienvenida */
        .welcome-showcase {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.9)) !important;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .welcome-showcase h1 {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
            color: #ffffff;
        }

        .welcome-showcase h1 span {
            color: #4f46e5;
        }

        .welcome-showcase .subtitle {
            font-size: 16px;
            color: #cbd5e1;
            max-width: 600px;
            margin: 0 auto 35px auto;
            line-height: 1.6;
        }

        /* Botón de acción principal */
        .btn-explore-shop {
            background-color: #4f46e5 !important;
            border: none !important;
            color: white !important;
            padding: 14px 32px !important;
            border-radius: 30px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        }

        .btn-explore-shop:hover {
            background-color: #4338ca !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.6);
        }

        /* Botón de WhatsApp Flotante NATIVO */
        .whatsapp-floating {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            text-decoration: none;
            transition: 0.3s;
        }

        .whatsapp-floating:hover {
            transform: scale(1.1);
        }

        .whatsapp-floating svg {
            width: 35px;
            height: 35px;
            fill: #ffffff;
        }

        /* =========================
                                                           CATÁLOGO DESTACADO
                                                        ========================= */

        .catalog-preview {
            margin-top: 40px;
            background: rgba(22, 30, 49, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .3);
        }

        .catalog-preview h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #ffffff;
        }

        .catalog-text {
            color: #cbd5e1;
            font-size: 15px;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto 40px auto;
        }

        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .catalog-card {
            overflow: hidden;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: .3s;
        }

        .catalog-card img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            transition: .3s;
        }

        .catalog-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, .35);
        }

        .catalog-card:hover img {
            transform: scale(1.05);
        }

        @media(max-width: 768px) {

            .catalog-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media(max-width: 480px) {

            .catalog-grid {
                grid-template-columns: 1fr;
            }

        }

        /* .catalog-actions {
                margin-top: 35px;
            } */
    </style>

    <div class="dashboard-container">

        <!-- Estado del Perfil del Usuario -->
        <div class="profile-status-card">
            <h4>Sesión Iniciada de Forma Segura</h4>
            <p>Bienvenido a tu panel de control personalizado en StyleMe.</p>
        </div>

        <!-- Módulo de bienvenida principal de la tienda -->
        <div class="welcome-showcase">
            <h1>¡Tu Clóset Inteligente está <span>Listo</span>!</h1>
            <p class="subtitle">
                Explora nuestro catálogo exclusivo de prendas de vestir administradas por inteligencia artificial. Diseños
                adaptados perfectamente a tus medidas, preferencias y últimas tendencias.
            </p>

            <!-- Redirección al catálogo o carrito -->
            <a href="{{ route('cart') }}" class="btn-explore-shop">
                Explora Colecciones
            </a>
        </div>

        <!-- ¿Por qué elegir StyleMe? -->
        <div class="profile-status-card mt-4">

            <h4>¿Por qué elegir StyleMe?</h4>

            <p style="margin-top:15px;">
                ✓ Personalización Inteligente
            </p>

            <p>
                ✓ Recomendaciones basadas en IA
            </p>

            <p>
                ✓ Diseños únicos adaptados a tu estilo
            </p>

            <p>
                ✓ Experiencia moderna y segura
            </p>

        </div>

        <!-- Catálogo Destacado -->
        <div class="catalog-preview">

            <h2>Nuestras Colecciones</h2>

            <p class="catalog-text">
                Descubre una nueva forma de vivir la moda con StyleMe.
                Diseños personalizados, recomendaciones inteligentes y prendas
                adaptadas a tu estilo.
            </p>

            @php
                $imagenes = [
                    '01.jpg',
                    '02.jpg',
                    '03.jpg',
                    '04.jpg',
                    '07.jpg',
                    '08.jpg',
                    '09.jpg',
                    '10.jpg',
                    '11.jpg',
                    '12.jpg',
                    '13.jpg',
                    '14.jpg',
                    '15.jpg',
                    '16.jpg',
                    '17.jpg',
                ];
            @endphp

            <div class="catalog-grid">

                @foreach ($imagenes as $img)
                    <div class="catalog-card">
                        <img src="{{ asset('imagenes/catalogo/' . $img) }}" alt="StyleMe">
                    </div>
                @endforeach

                {{-- <div class="catalog-actions">
                    <a href="{{ route('cart') }}" class="btn-explore-shop">
                        Ver Todo el Catálogo
                    </a>
                </div> --}}

            </div>

        </div>

    </div>

    <!-- Enlace de asistencia por WhatsApp con icono vectorial SVG integrado -->
    <a href="https://wa.me" class="whatsapp-floating" target="_blank">
        <svg viewBox="0 0 448 512">
            <path
                d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-117zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
        </svg>
    </a>
@endsection

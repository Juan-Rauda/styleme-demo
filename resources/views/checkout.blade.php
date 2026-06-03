@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cloudflare.com">

    <style>
        /* Sincronización con el ecosistema StyleMe */
        body {
            background-color: #0b0f19 !important;
            color: #ffffff;
        }

        .checkout-container {
            max-width: 750px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .checkout-card {
            background: rgba(22, 30, 49, 0.6) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            border-radius: 16px !important;
            padding: 35px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .checkout-header h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 5px;
            text-align: center;
        }

        .checkout-header p {
            color: #94a3b8;
            font-size: 15px;
            text-align: center;
            margin-bottom: 35px;
        }

        /* Lista de productos en el resumen */
        .checkout-item-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .checkout-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .checkout-item-details h4 {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 5px 0;
            color: #ffffff;
        }

        .checkout-item-details p {
            font-size: 14px;
            color: #94a3b8;
            margin: 0;
        }

        /* Botón eliminar minimalista */
        .btn-delete-item {
            background: transparent;
            border: none;
            color: #f87171;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            margin-top: 5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: 0.2s;
        }

        .btn-delete-item:hover {
            color: #ef4444;
            text-decoration: underline;
        }

        .checkout-item-price {
            font-size: 16px;
            font-weight: 700;
            color: #38bdf8;
        }

        /* Bloque de Total */
        .checkout-total-block {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 0;
            margin-top: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .checkout-total-block h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: #94a3b8;
        }

        .checkout-total-block .total-price {
            font-size: 26px;
            font-weight: 800;
            color: #38bdf8;
        }

        /* Bloque de botones de acción */
        .checkout-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-checkout-secondary {
            background-color: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #cbd5e1 !important;
            padding: 14px 24px !important;
            border-radius: 8px !important;
            font-weight: 700 !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex: 1;
            transition: 0.2s;
        }

        .btn-checkout-secondary:hover {
            background-color: #334155 !important;
            color: #ffffff !important;
        }

        .btn-checkout-primary {
            background-color: #4f46e5 !important;
            border: none !important;
            color: white !important;
            padding: 14px 24px !important;
            border-radius: 8px !important;
            font-weight: 700 !important;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex: 1;
            transition: 0.2s;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-checkout-primary:hover {
            background-color: #4338ca !important;
            transform: translateY(-1px);
        }

        /* Estado Carrito Vacío */
        .empty-cart-state {
            text-align: center;
            padding: 40px 0;
        }

        .empty-cart-state i {
            font-size: 60px;
            color: #334155;
            margin-bottom: 20px;
        }

        .empty-cart-state p {
            color: #94a3b8;
            font-size: 16px;
            margin-bottom: 25px;
        }

        /* 1. Definir el tamaño y ancho de la barra */
        .checkout-scroll-area::-webkit-scrollbar {
            width: 8px;
            /* Barra delgada */
        }

        /* 2. El fondo de la barra por donde corre el scroll (Track) */
        .checkout-scroll-area::-webkit-scrollbar-track {
            background: #1e293b;
            /* Azul grisáceo oscuro acorde a tu fondo */
            border-radius: 10px;
        }

        /* 3. El indicador que se mueve (Thumb) */
        .checkout-scroll-area::-webkit-scrollbar-thumb {
            background: #4f46e5;
            /* El mismo color morado de tus botones primarios */
            border-radius: 10px;
        }

        /* 4. Color cuando el usuario pasa el mouse encima */
        .checkout-scroll-area::-webkit-scrollbar-thumb:hover {
            background: #6366f1;
            /* Un morado un poco más brillante */
        }
    </style>

    <div class="checkout-container">
        <div class="checkout-card">

            <div class="checkout-header">
                <h1>Checkout de Compra</h1>
                <p>Revisa los artículos de tu orden antes de proceder al pago seguro</p>
            </div>

            <!-- Contenedor dinámico controlado por JavaScript -->
            <div id="carrito-container"></div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>

    <script>
        // Cargar el carrito del LocalStorage
        var carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        var carritoContainer = document.getElementById('carrito-container');

        function eliminarProducto(index) {
            var producto = carrito[index];

            if (producto.cantidad === 1) {
                Swal.fire({
                    title: '¿Retirar producto?',
                    text: 'Esta acción removerá la prenda seleccionada de tu resumen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Sí, remover',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        carrito.splice(index, 1);
                        actualizarCarritoYRender();
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Modificar cantidad',
                html: `
                <p>¿Cuántas unidades deseas retirar de este diseño?</p>
                <div style="display:flex; justify-content:center; align-items:center; gap:10px; margin-top:15px;">
                    <label style="font-weight:bold;">Cantidad a quitar:</label>
                    <input type="number" id="cantidad_restar" class="swal2-input" value="1" min="1" max="${producto.cantidad}"
                        style="width:80px; text-align:center; margin:0; font-weight:bold;">
                </div>
                <p style="font-size:12px; color:#94a3b8; margin-top:10px;">(Unidades actuales en la orden: ${producto.cantidad})</p>
            `,
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#4f46e5',
                denyButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Restar Unidades',
                denyButtonText: 'Quitar Todo el Bloque',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const cantidadARestar = parseInt(document.getElementById('cantidad_restar').value);
                    if (isNaN(cantidadARestar) || cantidadARestar < 1 || cantidadARestar > producto.cantidad) {
                        Swal.showValidationMessage(
                            `Por favor ingresa un número entre 1 y ${producto.cantidad}`);
                    }
                    return cantidadARestar;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var cantidadARestar = result.value;

                    if (cantidadARestar >= producto.cantidad) {
                        carrito.splice(index, 1);
                    } else {
                        carrito[index].cantidad -= cantidadARestar;
                    }
                    actualizarCarritoYRender();
                } else if (result.isDenied) {
                    carrito.splice(index, 1);
                    actualizarCarritoYRender();
                }
            });
        }

        function actualizarCarritoYRender() {
            localStorage.setItem('carrito', JSON.stringify(carrito));
            mostrarProductosDelCarrito();
            Swal.fire({
                title: 'Actualizado',
                text: 'Tu orden ha sido modificada.',
                icon: 'success',
                timer: 1000,
                showConfirmButton: false
            });
        }

        function mostrarProductosDelCarrito() {
            if (carrito.length === 0) {
                carritoContainer.innerHTML = `
                <div class="empty-cart-state" style="text-align: center; padding: 40px 20px;">
                    <i class="fas fa-shopping-bag" style="font-size: 48px; color: #4f46e5; margin-bottom: 15px;"></i>
                    <p>Tu bolsa de compras está vacía de momento.</p>
                    <a href="{{ route('cart') }}" class="btn-checkout-secondary" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; width:auto; margin-top:15px; padding: 10px 20px; text-decoration: none; color: #94a3b8; background-color: #1e293b; border: 1px solid #334155; border-radius: 8px;">
                        <svg viewBox="0 0 576 512" style="width: 16px; height: 16px; fill: currentColor;"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 448a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                        Volver al Catálogo
                    </a>
                </div>`;
            } else {
                var carritoHTML = `
                <div class="checkout-scroll-area" style="max-height: 280px; overflow-y: auto; padding-right: 8px; margin-bottom: 20px;">
                    <ul class="checkout-item-list" style="list-style: none; padding: 0; margin: 0;">`;

                carrito.forEach(function(producto, index) {

                    let nombrePrenda =
                        producto.tipoPrenda || 'Prenda';

                    if (nombrePrenda === 'premium cotton t-shirt') {
                        nombrePrenda = 'Camisa Premium';
                    }

                    if (nombrePrenda === 'black hoodie') {
                        nombrePrenda = 'Hoodie';
                    }

                    var imagenSrc =
                        producto.imagen
                            ? producto.imagen
                            : '/img/default-shirt.png';

                    carritoHTML += `
                    <li class="checkout-item" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; padding: 10px; background: #1e293b; border-radius: 8px;">

                        <div style="display: flex; align-items: center; gap: 15px;">

                            <img
                                src="${imagenSrc}"
                                alt="Prenda IA"
                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #334155;"
                            >

                            <div class="checkout-item-details">

                                <h4 style="margin:0 0 5px 0; font-size:15px; color:#ffffff;">
                                    ${nombrePrenda} - ${producto.talla || 'N/A'}
                                </h4>

                                <p style="margin:0 0 4px 0; font-size:13px; color:#94a3b8;">
                                    Tipo: ${nombrePrenda}
                                </p>

                                <p style="margin:0 0 4px 0; font-size:13px; color:#94a3b8;">
                                    Talla: ${producto.talla || 'N/A'}
                                </p>

                                <p style="margin:0 0 4px 0; font-size:13px; color:#94a3b8;">
                                    Cantidad: ${producto.cantidad}
                                </p>

                                <p style="display:flex;align-items:center;gap:8px;margin:0 0 6px 0;font-size:13px;color:#94a3b8;">
                                    Color:

                                    <span style="
                                        width:18px;
                                        height:18px;
                                        border-radius:50%;
                                        display:inline-block;
                                        background:${producto.color || '#64748b'};
                                        border:1px solid #64748b;
                                    "></span>

                                </p>

                                ${
                                    producto.prompt
                                    ?
                                    `<p style="
                                        font-size:11px;
                                        color:#64748b;
                                        margin:0 0 8px 0;
                                        max-width:250px;
                                        overflow:hidden;
                                        text-overflow:ellipsis;
                                        white-space:nowrap;
                                    ">
                                        ${producto.prompt}
                                    </p>`
                                    : ''
                                }

                                <button
                                    class="btn-delete-item"
                                    onclick="eliminarProducto(${index})"
                                    style="background:none; border:none; color:#ef4444; font-size:13px; cursor:pointer; display:flex; align-items:center; gap:6px; padding:0;"
                                >
                                    <i class="fas fa-minus-circle"></i>
                                    Ajustar cantidad
                                </button>

                            </div>

                        </div>

                        <div class="checkout-item-price" style="font-weight:700; color:#38bdf8; font-size:16px;">
                            $${(producto.precio * producto.cantidad).toFixed(2)}
                        </div>

                    </li>`;
                });

                var totalVenta = carrito.reduce(function(total, producto) {
                    return total + (producto.precio * producto.cantidad);
                }, 0);

                carritoHTML += `
                </ul>
            </div>
            <div class="checkout-total-block" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #334155;">
                <h3>Total de tu Orden (USD)</h3>
                <div class="total-price">$${totalVenta.toFixed(2)}</div>
            </div>

            <div class="checkout-actions" style="display: flex; gap: 12px; margin-top: 25px; align-items: center; width: 100%;">
                <a href="{{ route('cart') }}" class="btn-checkout-secondary" style="flex: 1; height: 46px; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700; font-size: 13px; margin: 0; text-align: center; border-radius: 8px; box-sizing: border-box; background-color: #1e293b; border: 1px solid #334155; text-decoration: none; color: #94a3b8;">
                    <svg viewBox="0 0 576 512" style="width: 16px; height: 16px; fill: currentColor;"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 448a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                    Seguir Comprando
                </a>

                <button type="button" onclick="vaciarCarritoCompleto()" class="btn-checkout-secondary" style="flex: 1; height: 46px; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700; font-size: 13px; margin: 0; text-align: center; border-radius: 8px; background-color: #ef4444 !important; color: white !important; border: none !important; box-sizing: border-box; cursor: pointer;">
                    <svg viewBox="0 0 448 512" style="width: 15px; height: 15px; fill: currentColor;"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                    Vaciar Carrito
                </button>

                <form method="GET" action="{{ route('processPaypal') }}" id="paypal-form" style="flex: 1.2; display: flex; margin: 0; padding: 0;">
                    <input type="hidden" name="usuario" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="carrito-input" name="carrito">
                    <input type="hidden" name="totalVenta" id="total-venta-input" value="${totalVenta.toFixed(2)}">

                    <button type="submit" id="finalizar-compra-button" class="btn-checkout-primary" style="width: 100%; height: 46px; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700; font-size: 13px; border-radius: 8px; margin: 0; padding: 0; box-shadow: none; cursor: pointer;">
                        <svg viewBox="0 0 576 512" style="width: 16px; height: 16px; fill: currentColor;"><path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm16 64H496c8.8 0 16 7.2 16 16v16H48V144c0-8.8 7.2-16 16-16zM48 240H528V368c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V240zM288 320a24 24 0 1 0 -48 0 24 24 0 1 0 48 0zm72 0a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg>
                        Pagar con PayPal
                    </button>
                </form>
            </div>`;

                carritoContainer.innerHTML = carritoHTML;

                var carritoInput = document.getElementById('carrito-input');
                if (carritoInput) {
                    carritoInput.value = JSON.stringify(carrito);
                }
            }
        }

        function vaciarCarritoCompleto() {
            Swal.fire({
                title: '¿Vaciar toda tu orden?',
                text: 'Esto removerá absolutamente todos los diseños de tu bolsa.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, vaciar todo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    carrito = [];
                    localStorage.setItem('carrito', JSON.stringify(carrito));
                    mostrarProductosDelCarrito();
                    Swal.fire('Bolsa Vacía', 'Se han removido todos los artículos.', 'success');
                }
            });
        }

        // INTERCEPTAR ENVÍO FORMULARIO PARA DESCARGAR IMAGEN LOCAL
        document.addEventListener('submit', function(e) {
            if (e.target && e.target.id === 'paypal-form') {
                if (carrito.length === 0) return;

                e.preventDefault();

                Swal.fire({
                    title: 'Asegurando tus diseños...',
                    text: 'Guardando los archivos planos PNG en el servidor local para la estampadora.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Creamos una lista de peticiones Fetch (promesas) para procesar todos los productos del carrito
                var peticionesDescarga = carrito.map(function(producto, index) {
                    // Si el producto no tiene prompt (es un producto normal de la tienda), saltamos la descarga
                    if (!producto.prompt) return Promise.resolve(null);

                    // Construimos el prompt aislado para obtener solo el logo plano
                    var promptAislado =
                        `centered print graphic design of: ${producto.prompt}, isolated, high definition vector asset, screen printing style, flat background`;
                    var cleanPrompt = encodeURIComponent(promptAislado);
                    var urlLogoPuro =
                        `https://image.pollinations.ai/prompt/${cleanPrompt}?model=turbo&width=512&height=512`;

                    // Retornamos la promesa del fetch hacia Laravel
                    return fetch("{{ route('guardar.estampado.local') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                url_imagen: urlLogoPuro
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Guardamos la ruta local de Laragon exactamente en este producto
                                return {
                                    index: index,
                                    url_local: data.url_local
                                };
                            }
                            return null;
                        })
                        .catch(error => {
                            console.error("Error descargando producto " + index, error);
                            return null;
                        });
                });

                // Ejecutamos todas las descargas en paralelo de forma segura
                Promise.all(peticionesDescarga).then(resultados => {
                    // Recorremos los resultados y actualizamos el carrito localmente
                    resultados.forEach(res => {
                        if (res !== null) {
                            carrito[res.index].imagen = res.url_local;
                        }
                    });

                    // Sincronizamos los cambios definitivos en el LocalStorage y en el input oculto para PayPal
                    localStorage.setItem('carrito', JSON.stringify(carrito));
                    document.getElementById('carrito-input').value = JSON.stringify(carrito);

                    Swal.fire({
                        icon: 'success',
                        title: '¡Diseños Asegurados!',
                        text: 'Todos los estampados fueron guardados en public/storage/estampados/',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Ahora que todo el carrito está actualizado con sus imágenes locales, enviamos a PayPal
                        e.target.submit();
                    });
                });
            }
        });

        // Renderizado inicial
        mostrarProductosDelCarrito();
    </script>
@endsection

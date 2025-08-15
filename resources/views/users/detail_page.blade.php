@extends('layouts.luxury-nav')

@section('title', 'เมนู')

@section('content')
    <?php
    
    use App\Models\Config;
    
    $config = Config::first();
    ?>
    <style>
        .title-food {
            font-size: 30px;
            font-weight: bold;
            color: <?=$config->color_font !='' ? $config->color_font : '#ffffff' ?>;
        }

        .card-food {
            background-color: var(--bg-card-food);
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
            padding: 4px;
        }

        .card-title {
            font-size: 15px;
            color: white;
        }

        .btn-gray-left {
            background-color: #d3d3d3;
            color: #333;
            border: none;
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
            padding: 0px 14px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .btn-gray-right {
            background-color: #d3d3d3;
            color: #333;
            border: none;
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
            padding: 0px 14px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .btn-gray-left:hover {
            background-color: #c0c0c0;
            transform: scale(1.05);
        }

        .btn-gray-right:hover {
            background-color: #c0c0c0;
            transform: scale(1.05);
        }

        .count {
            background-color: #e0e0e0;
            padding: 1.5px 0px;
        }

        .custom-height-offcanvas {
            height: 95vh !important;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            overflow-y: auto;
            padding: 0;
        }

        .custom-height-offcanvas2 {
            height: 70vh !important;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            overflow-y: auto;
            padding: 0;
        }

        .img-cover-wrapper {
            position: relative;
        }

        .btn-close-top-left {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: white;
            border-radius: 50%;
            padding: 0.5rem 0.5rem;
            z-index: 10;
        }

        .text-alret-blue {
            background-color: #d9fcff;
        }

        .text-alret-gray {
            background-color: #f3f3f3;
        }

        .btn-plus {
            background-color: #cccccc;
            color: #999999;
            border-radius: 50%;
            border: 0px solid #333;
            font-size: 20px;
            padding: 0px 8px;
            cursor: not-allowed;
        }

        .btn-minus {
            background-color: #cccccc;
            color: #999999;
            border-radius: 50%;
            border: 0px solid #333;
            font-size: 20px;
            padding: 0px 8px;
            cursor: not-allowed;
        }

        .cart-amount-badge {
            position: absolute;
            bottom: 5px;
            right: 20px;
            transform: translateX(50%);
            border: 1px solid #30acff;
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            padding: 2px 10px;
            font-size: 13px;
            border-radius: 50%;
            z-index: 10;
        }

        .amount-custom {
            border: 1px solid #30acff;
            border-radius: 50%;
            padding: 0px 8px;
            color: #30acff;
        }

        /* ปิดการใช้งานการ์ดสินค้า */
        .product-card {
            cursor: default !important;
            opacity: 0.8;
        }

        .product-card:hover {
            opacity: 1;
        }

        /* ซ่อนปุ่มทั้งหมดที่เกี่ยวกับการสั่งอาหาร */
        .add-to-cart-btn,
        .back-menu,
        .add-button,
        .btn-plus,
        .btn-minus {
            display: none !important;
        }

        /* ปิดการใช้งาน checkbox */
        .option-checkbox {
            pointer-events: none;
            opacity: 0.5;
        }

        /* ปิดการใช้งาน textarea */
        textarea {
            pointer-events: none;
            background-color: #f8f9fa;
            opacity: 0.7;
        }

        /* แสดงข้อความแจ้งเตือน */
        .view-only-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>

    <div class="container">
        <div class="d-flex flex-column justify-content-center gap-2">
            <div class="title-food">
                หมวดอาหาร
            </div>
            
            <div class="view-only-notice">
                <i class="fa-solid fa-eye me-2"></i>
                <strong>โหมดดูเมนู:</strong> คุณสามารถดูรายการอาหารและรายละเอียดได้เท่านั้น ไม่สามารถสั่งอาหารได้
            </div>

            <div class="row justify-content-center gap-3">
                @foreach ($menu as $rs)
                    <div class="col-5 g-0 product-card" style="border-radius: 10px;" data-id="{{ $rs['id'] }}">
                        <div class="row g-0 flex-column">
                            <div class="col">
                                <div class="position-relative">
                                    @if ($rs['files'])
                                        <img src="{{ url('storage/' . $rs['files']->file) }}" class="img-fluid rounded"
                                            style="width: 100%; height: 130px; object-fit: cover; border-radius: 10px;"
                                            alt="food">
                                    @else
                                        <img src="{{ asset('foods/default-photo.png') }}" class="img-fluid rounded"
                                            style="width: 100%; height: 130px; object-fit: cover; border-radius: 10px;"
                                            alt="food">
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-0 pt-2 text-start" style="background-color: transparent;">
                                    <h5 class="m-0 card-title">{{ $rs['name'] }}</h5>
                                    <p class="fw-bold card-title mb-0">{{ $rs['base_price'] }} ฿</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="offcanvas offcanvas-bottom custom-height-offcanvas border-top-0" tabindex="-1"
                        id="offcanvasView-{{ $rs['id'] }}" aria-labelledby="offcanvasView">

                        <div class="img-cover-wrapper">
                            <button type="button" class="btn-close btn-close-top-left" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>

                            @if ($rs['files'])
                                <img src="{{ url('storage/' . $rs['files']->file) }}" class="img-cover"
                                    style="width: 100%; height: 200px; object-fit: cover;" alt="food">
                            @else
                                <img src="{{ asset('foods/default-photo.png') }}" class="img-cover"
                                    style="width: 100%; height: 200px; object-fit: cover;" alt="food">
                            @endif
                        </div>

                        <div class="offcanvas-body small px-3">
                            <div class="row justify-content-between align-items-start mb-2">
                                <div class="col-9 text-start">
                                    <h5 class="offcanvas-title fw-bold mb-0 fs-5 product-name">{{ $rs['name'] }}</h5>
                                    <div class="text-muted ps-1" style="line-height: 1.0;">{{ $rs['detail'] }}</div>
                                </div>
                                
                                <div class="col-3 text-start text-end fs-5 fw-bold" style="line-height: 1.0;">
                                    {{ $rs['base_price'] }} ฿<br>
                                    <span class="text-muted" style="font-size: 14px; font-weight: normal;">ราคาเริ่มต้น</span>
                                </div>
                            </div>
                            <hr class="my-1">

                            @foreach ($rs['option'] as $type => $optionGroup)
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <h6 class="fs-6 fw-bold mb-0">{{ $type }}</h6>
                                    <small class="text-muted px-2 rounded-5 {{ $optionGroup['is_selected'] == 1 ? 'text-alret-blue' : 'text-alret-gray' }}">
                                        @if ($optionGroup['is_selected'] == 1)
                                            เลือก {{ $optionGroup['amout'] }}
                                        @else
                                            ไม่จำเป็นต้องระบุ
                                        @endif
                                    </small>
                                </div>

                                @foreach ($optionGroup['items'] as $option)
                                    <div class="d-flex justify-content-between align-items-center py-0">
                                        <div class="form-check d-flex justify-content-between align-items-center w-100 mb-0 py-0">
                                            <div>
                                                <input class="form-check-input me-2 option-checkbox" type="checkbox"
                                                    disabled readonly
                                                    id="option_view_{{ $option->id }}">
                                                <label class="form-check-label" for="option_view_{{ $option->id }}">
                                                    {{ $option->name }}
                                                </label>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center" style="min-width: 60px;">
                                                <i class="fa-solid fa-plus" style="font-size: 9px; margin-right: 1px;"></i>
                                                <span>{{ $option->price }} ฿</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <hr>
                            @endforeach

                            <div class="mt-3 text-start">
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <label class="form-label fw-bold fs-6">หมายเหตุถึงร้านอาหาร</label>
                                    <small class="text-muted px-2 rounded-5 text-alret-gray">
                                        ไม่จำเป็นต้องระบุ
                                    </small>
                                </div>
                                <textarea class="form-control" rows="3" readonly
                                    placeholder="ระบุรายละเอียดคำขอ (ขึ้นอยู่กับดุลยพินิจของร้าน)"></textarea>
                            </div>

                            <!-- ข้อความแจ้งเตือนในโหมดดูเมนู -->
                            <div class="text-center mt-4 mb-4">
                                <div class="alert alert-info">
                                    <i class="fa-solid fa-info-circle me-2"></i>
                                    นี่คือโหมดดูเมนูเท่านั้น ไม่สามารถสั่งอาหารได้
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(card => {
                card.addEventListener('click', function() {
                    const productId = this.dataset.id;
                    const targetId = `#offcanvasView-${productId}`;
                    const targetEl = document.querySelector(targetId);
                    
                    if (!targetEl) return;

                    const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(targetEl);
                    bsOffcanvas.show();
                });
            });

            console.log('📖 โหมดดูเมนู: การสั่งอาหารถูกปิดใช้งาน');
        });
    </script>
@endsection
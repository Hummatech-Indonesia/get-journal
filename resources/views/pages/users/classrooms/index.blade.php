@extends('layouts.auth')

@section('title', 'Kelas')

@section('content')
    @include('components.swal')
    <div class="d-flex h-100 flex-column align-self-stretch">
        <div class="row">
            <div class="col-9 col-md-6 col-lg-4 col-xl-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="cari..." name="search">
                    <div class="input-group-text">
                        <i class="fa-duotone fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-3 col-lg-6 col-xl-7"></div>
            <div class="col-3 col-md-3 col-lg-2">
                <select name="per_page" id="per_page" class="form-select">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <div class="row mt-5 flex-1" id="classroom_lists">
            
        </div>

        <div class="d-flex justify-content-center align-items-center" id="classroom_pagination"></div>
    </div>

    <div class="loader-container" style="display: none">
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
@endsection

@push('style')
    <style>
        .loader-container {
            position: fixed;
            z-index: 999;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.342);
            display: grid;
            place-content: center;
        }
        .lds-roller {
            /* change color here */
            color: #e15b64
        }
        .lds-roller, .lds-roller div, .lds-roller div:after {
            box-sizing: border-box;
        }
        .lds-roller {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }
        .lds-roller div {
            animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            transform-origin: 40px 40px;
        }
        .lds-roller div:after {
            content: " ";
            display: block;
            position: absolute;
            width: 7.2px;
            height: 7.2px;
            border-radius: 50%;
            background: currentColor;
            margin: -3.6px 0 0 -3.6px;
        }
        .lds-roller div:nth-child(1) {
            animation-delay: -0.036s;
        }
        .lds-roller div:nth-child(1):after {
            top: 62.62742px;
            left: 62.62742px;
        }
        .lds-roller div:nth-child(2) {
            animation-delay: -0.072s;
        }
        .lds-roller div:nth-child(2):after {
            top: 67.71281px;
            left: 56px;
        }
        .lds-roller div:nth-child(3) {
            animation-delay: -0.108s;
        }
        .lds-roller div:nth-child(3):after {
            top: 70.90963px;
            left: 48.28221px;
        }
        .lds-roller div:nth-child(4) {
            animation-delay: -0.144s;
        }
        .lds-roller div:nth-child(4):after {
            top: 72px;
            left: 40px;
        }
        .lds-roller div:nth-child(5) {
            animation-delay: -0.18s;
        }
        .lds-roller div:nth-child(5):after {
            top: 70.90963px;
            left: 31.71779px;
        }
        .lds-roller div:nth-child(6) {
            animation-delay: -0.216s;
        }
        .lds-roller div:nth-child(6):after {
            top: 67.71281px;
            left: 24px;
        }
        .lds-roller div:nth-child(7) {
            animation-delay: -0.252s;
        }
        .lds-roller div:nth-child(7):after {
            top: 62.62742px;
            left: 17.37258px;
        }
        .lds-roller div:nth-child(8) {
            animation-delay: -0.288s;
        }
        .lds-roller div:nth-child(8):after {
            top: 56px;
            left: 12.28719px;
        }
        @keyframes lds-roller {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('script')
    <script>
        getSchool()

        function getSchool(url = "{{ route('list.classrooms') }}") {
            $('.loader-container').show()
            $.ajax({
                url,
                data: {
                    search: $('[name=search]').val(),
                    _token: "{{ csrf_token() }}",
                    user_id: "{{ auth()->id() }}",
                    per_page: $('[name=per_page]').val(),
                },
                success: (res) => {
                    drawClassroomCard(res.data.data)
                    drawPagination(res.data.links)
                    $('.loader-container').hide()
                }
            })
        }

        $(document).on('change', '[name=per_page]', function() {getSchool()})

        let search_timeout

        $(document).on('input', '[name=search]', function() {
            clearTimeout(search_timeout)
            search_timeout = setTimeout(() => {
                getSchool()
            }, 500);
        })

        function drawClassroomCard(data) {
            let classroom_cards = ''
            const default_bg = "{{ asset('assets/media/stock/600x400/img-56.jpg') }}"
            data.map((d) => {
                let class_bg = default_bg
                if(d.background.image) class_bg = "{{asset('/storage')}}"+d.background.image
                classroom_cards += `
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card mb-5" style="background-image: linear-gradient(to bottom, rgba(0,0,0,.2), rgba(0,0,0,.8)), url(${class_bg});background-size: cover; min-height:150px;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-stetch">
                                        <div class="h1 text-white mb-0">${d.name}</div>
                                        <div class="badge badge-xl border border-white rounded text-white">${d.code}</div>
                                    </div>
                                    <div class="text-white">oleh ${d.profile.name}</div>
                                </div>
                                <div class="table-responsive d-flex gap-2 flex-nowrap">
                                    <span class="badge border border-white rounded text-white">${d.students_count} / ${d.limit} Siswa</span>
                                    <span class="badge border border-white rounded text-white">${d.assignments_count} Tugas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            })
            $('#classroom_lists').html(classroom_cards)
        }

        function drawPagination(links) {
            let used_links = createPagination(links)
            let pagination_el = '<nav aria-label="Page navigation"><ul class="pagination">'
            used_links.map(link => {
                pagination_el +=
                    `<li class="page-item ${link.active ? 'active' : ''} ${link.disabled !== undefined && link.disabled ? 'disabled' : ''}"><a class="page-link" data-url="${link.url}" href="#">${link.label}</a></li>`
            })
            pagination_el += '</ul></nav>'

            $('#classroom_pagination').html(pagination_el)
        }

        function createPagination(data) {
            const prevPage = data.splice(0, 1)[0]
            const nextPage = data.splice(data.length - 1, 1)[0]

            const activePage = data.find(page => page.active);

            if (!activePage) return [];

            const activeIndex = data.indexOf(activePage);

            if (activeIndex == 0) prevPage.disabled = true
            if (activeIndex == data.length - 1) nextPage.disabled = true

            let start, end;

            if (data.length < 5) {
                start = 0
                end = data.length - 1
            } else if (activeIndex <= 2) {
                start = 0
                end = 4
            } else if (activeIndex >= data.length - 2) {
                start = data.length - 5
                end = data.length - 1
            } else {
                start = activeIndex - 2
                end = activeIndex + 2
            }

            const pagination = [];
            pagination.push(prevPage)
            for (let i = start; i <= end; i++) {
                pagination.push(data[i]);
            }
            pagination.push(nextPage);

            return pagination;
        }

        $(document).on('click', '.page-link', function() {
            getSchool($(this).attr('data-url'))
        })
    </script>
@endpush

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CBT | Admin</title>
    <!-- fontawesome -->
    <link rel="stylesheet" href="/fontawesome/css/all.min.css" />

    <!-- favicon -->
    <link rel="icon" type="image/svg+xml" href="/assets/logo-sekolah.png">

    {{-- quill --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="/build/assets/app-CMdHnh2Y.css">
    <script src="/build/assets/app-BYiNv_yN.js" defer></script>
</head>

<body>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        {{-- sidebar --}}
        <div class="z-50 drawer-side">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            @include('components.sidebar.sidebar')
        </div>
        {{-- sidebar --}}

        {{-- navbar --}}
        <div class="drawer-content">
            @include('components.navbar.navbar')
        </div>
        {{-- navbar --}}

        {{-- content --}}
        <div class="drawer-content">
            <div class="min-h-screen p-4 mt-16">
                {{-- <div class="alert-container">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>
                                    <h5 class="mb-1 alert-heading">Submission Failed</h5>
                                    <div class="error-message">{!! session('error') !!}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif --}}

                {{-- @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div>
                                    <h5 class="mb-1 alert-heading">Validation Errors</h5>
                                    <ul class="mb-0 error-list">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif --}}

                {{-- @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>
                                    <h5 class="mb-1 alert-heading">Success!</h5>
                                    <div>{{ session('success') }}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                </div> --}}

                <div class="grid grid-cols-1">
                    <div class="w-auto shadow-sm card bg-white-custom">
                        <div class="card-body">
                            <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom">Tambah Soal Ujian</h3>
                            <form action="{{ route('master_soal.store-soal') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- @csrf

                                {{-- Soal Ujian --}}
                                <div class="w-full p-6 mx-auto bg-white rounded-lg shadow" id="form-container">

                                    <!-- Soal (akan di-clone) -->

                                    <div class="pb-4 mb-6 border-b question-block" id="question-template">
                                        <div class="flex items-center justify-between mb-4">
                                            <input type="text" placeholder="Untitled Question"
                                                class="w-full mr-4 bg-gray-100 input input-bordered question-title"
                                                name="soal[__index__][judul]" />

                                            <!-- Gambar -->
                                            <label
                                                class="inline-flex items-center gap-2 cursor-pointer text-black-custom">
                                                <i class="text-xl fa-solid fa-image"></i>
                                                <input type="file" accept="image/*" class="hidden question-image"
                                                    name="soal[__index__][gambar]" />
                                            </label>

                                            <img class="hidden max-w-xs mt-2 rounded shadow preview-image" />

                                            <select class="w-48 ml-4 select select-bordered question-type"
                                                name="soal[__index__][tipe]">
                                                <option value="multiple">Multiple choice</option>
                                                <option value="checkbox">Checkboxes</option>
                                                <option value="short">Short answer</option>
                                            </select>
                                        </div>

                                        <!-- Opsi -->
                                        <div class="space-y-2 option-list"></div>

                                        <div class="mt-2 text-sm cursor-pointer text-blue-custom add-option">+ Add
                                            option</div>

                                        <div class="flex items-center justify-between mt-4">
                                            <div class="flex gap-4">
                                                <button type="button" class="duplicate-question">
                                                    <img src="https://img.icons8.com/ios-glyphs/20/duplicate.png" />
                                                </button>
                                                <button type="button" class="remove-question">
                                                    <img src="https://img.icons8.com/ios-glyphs/20/filled-trash.png" />
                                                </button>
                                            </div>
                                            <label class="flex items-center gap-2">
                                                <span>Required</span>
                                                <input type="checkbox" class="toggle toggle-sm required-toggle"
                                                    name="soal[__index__][required]" />
                                            </label>
                                        </div>
                                    </div>


                                    <!-- Kontainer pertanyaan -->
                                    <div id="questions-container"></div>

                                    <!-- Tombol tambah soal -->
                                    <div class="text-center">
                                        <button type="button" id="add-question-btn"
                                            class="mt-4 btn bg-blue-custom text-white-custom">+ Add Question</button>
                                    </div>
                                </div>
                                {{-- Soal Ujian --}}

                                {{-- Button --}}
                                <div class="flex flex-wrap gap-1 pt-4">
                                    <button type="submit" class="btn bg-blue-custom text-white-custom">
                                        <i class="fa-regular fa-floppy-disk text-white-custom"></i> Simpan
                                    </button>
                                    <button type="button" class="btn bg-red-custom text-white-custom" id="batal">
                                        <i class="fa-regular fa-circle-xmark text-white-custom"></i> Batal
                                    </button>
                                </div>
                                {{-- </form> --}}

                                {{-- JavaScript --}}
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- content --}}
    </div>

    {{-- quill --}}

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const blocks = document.querySelectorAll('.question-block');

            blocks.forEach((block, index) => {
                const container = document.createElement('div');
                container.style.display = 'none';

                // Judul Soal
                const title = block.querySelector('.question-title').value;
                container.appendChild(createInput(`question_title_${index}`, title));

                // Tipe Soal
                const type = block.querySelector('.question-type').value;
                container.appendChild(createInput(`question_type_${index}`, type));

                // Required toggle
                const isRequired = block.querySelector('.required-toggle').checked;
                if (isRequired) {
                    container.appendChild(createInput(`question_required_${index}`, 'on'));
                }

                // Gambar (biarkan file tetap diinput, sudah otomatis ke form)
                const imgInput = block.querySelector('.question-image');
                if (imgInput && imgInput.files.length > 0) {
                    imgInput.name = `question_image_${index}`; // rename input file
                }

                // Opsi
                if (type !== 'short') {
                    const options = block.querySelectorAll('.option-input');
                    options.forEach(opt => {
                        container.appendChild(createInput(`question_options_${index}[]`, opt
                            .value));
                    });

                    // Jawaban benar (sementara ambil dari input terakhir, bisa disesuaikan)
                    const answer = options[0]?.value || ''; // bisa diganti logic-nya
                    container.appendChild(createInput(`question_answer_${index}`, answer));
                }

                block.appendChild(container);
            });

            // Helper: buat input tersembunyi
            function createInput(name, value) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = value;
                return input;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const questionsContainer = document.getElementById('questions-container');
            const questionTemplate = document.getElementById('question-template');
            const addQuestionBtn = document.getElementById('add-question-btn');

            function addQuestion(data = null) {
                const index = document.querySelectorAll('.question-block').length;

                // Ambil template sebagai string, lalu ganti __index__ jadi angka
                const templateHTML = questionTemplate.innerHTML.replace(/__index__/g, index);

                // Bungkus HTML hasil replace ke elemen baru
                const wrapper = document.createElement('div');
                wrapper.className = 'question-block border-b pb-4 mb-6';
                wrapper.innerHTML = templateHTML;

                const typeSelect = wrapper.querySelector('.question-type');
                const optionList = wrapper.querySelector('.option-list');

                // Event saat ganti tipe
                typeSelect.addEventListener('change', () => {
                    const type = typeSelect.value;
                    optionList.innerHTML = '';
                    if (type === 'short') {
                        optionList.innerHTML =
                            `<input type="text" class="w-full mt-2 input input-bordered" placeholder="Short answer text" disabled />`;
                    } else {
                        addOption(wrapper, 'Option 1');
                        addOption(wrapper, 'Option 2');
                    }
                });

                wrapper.querySelector('.add-option').onclick = () => addOption(wrapper);
                wrapper.querySelector('.remove-question').onclick = () => wrapper.remove();
                wrapper.querySelector('.duplicate-question').onclick = () => {
                    const cloneData = serializeQuestion(wrapper);
                    addQuestion(cloneData);
                };

                // Restore data kalau ada
                if (data) {
                    wrapper.querySelector('.question-title').value = data.title || '';
                    wrapper.querySelector('.required-toggle').checked = data.required || false;
                    typeSelect.value = data.type || 'multiple';
                    typeSelect.dispatchEvent(new Event('change'));
                    if (data.type !== 'short') {
                        data.options.forEach(opt => addOption(wrapper, opt));
                    }
                } else {
                    typeSelect.value = 'multiple';
                    typeSelect.dispatchEvent(new Event('change'));
                }

                // Gambar
                const imageInput = wrapper.querySelector('.question-image');
                const imagePreview = wrapper.querySelector('.preview-image');
                imageInput.addEventListener('change', () => {
                    const file = imageInput.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = e => {
                            imagePreview.src = e.target.result;
                            imagePreview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.src = '';
                        imagePreview.classList.add('hidden');
                    }
                });

                questionsContainer.appendChild(wrapper);
            }


            function addOption(questionElem, value = '') {
                const indexMatch = questionElem.querySelector('.question-title')?.name?.match(/\[(\d+)\]/);
                const index = indexMatch ? indexMatch[1] : 0;

                const type = questionElem.querySelector('.question-type').value;
                const optionList = questionElem.querySelector('.option-list');
                const inputType = type === 'checkbox' ? 'checkbox' : 'radio';

                const optionRow = document.createElement('div');
                optionRow.className = 'flex items-center mt-2';
                optionRow.innerHTML = `
        <input type="${inputType}" disabled class="mr-3" />
        <input type="text" class="w-full input input-bordered option-input" name="soal[${index}][opsi][]" value="${value || `Option ${optionList.children.length + 1}`}" />
        <button type="button" class="ml-2 font-bold text-red-500 remove-option">&times;</button>
    `;
                optionRow.querySelector('.remove-option').onclick = () => optionRow.remove();
                optionList.appendChild(optionRow);
            }




            function serializeQuestion(questionElem) {
                return {
                    title: questionElem.querySelector('.question-title').value,
                    required: questionElem.querySelector('.required-toggle').checked,
                    type: questionElem.querySelector('.question-type').value,
                    options: Array.from(questionElem.querySelectorAll('.option-input')).map(i => i.value),
                    image: questionElem.querySelector('.preview-image')?.src || null
                };
            }

            // Tambah pertama kali
            addQuestion();

            addQuestionBtn.addEventListener('click', () => addQuestion());
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.editor').forEach((el) => {
                new Quill(el, {
                    theme: 'snow'
                });
            });
        });
    </script>

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ================= GLOBAL DRAG ================= */
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => {
            document.addEventListener(e, ev => {
                ev.preventDefault();
                ev.stopPropagation();
            });
        });

        /* ================= DROPZONE ================= */
        const dropzones = document.querySelectorAll('.dropzone');

        dropzones.forEach(zone => {
            const inputId = zone.dataset.input;
            const input = document.getElementById(inputId);
            const previewId = 'preview-' + inputId;
            const preview = document.getElementById(previewId);


            if (!input) {
                console.error('Input not found for:', inputId);
                return;
            }

            if (!preview) {
                console.error('Preview not found for:', previewId);
                return;
            }


            // Click handler to open file dialog
            zone.addEventListener('click', (e) => {
                input.click();
            });

            // drag UI only (no file injection for single)
            ['dragenter', 'dragover'].forEach(e =>
                zone.addEventListener(e, () => {
                    zone.classList.add('drag');
                })
            );
            ['dragleave', 'drop'].forEach(e =>
                zone.addEventListener(e, () => {
                    zone.classList.remove('drag');
                })
            );

            // Handle drop للـ single و multiple files
            zone.addEventListener('drop', e => {
                const files = e.dataTransfer.files;
                if (!files.length) return;

                // للـ single photo: خذ أول ملف فقط
                if (!input.multiple) {
                    const dt = new DataTransfer();
                    dt.items.add(files[0]);
                    input.files = dt.files;
                } else {
                    // للـ gallery: خذ كل الملفات
                    input.files = files;
                }
                renderFiles(input, preview);
            });

            // File change event (when user selects via dialog)
            input.addEventListener('change', () => {

                // إذا كان هذا الـ photo input وفيه ملفات جديدة، حذف الصورة القديمة
                if (inputId === 'photo' && input.files.length > 0) {
                    const existingPhoto = document.getElementById('existing-photo');
                    if (existingPhoto) {
                        existingPhoto.remove();
                        const removePhotoInput = document.getElementById('remove_photo');
                        if (removePhotoInput) {
                            removePhotoInput.value = 1;
                        }
                    }
                }

                renderFiles(input, preview);
            });
        });


        /* ================= RENDER FILES ================= */
        function renderFiles(input, preview) {
            preview.innerHTML = '';
            preview.classList.remove('hidden');

            const files = [...input.files];

            if (files.length === 0) {
                preview.classList.add('hidden');
                return;
            }

            // استخدم DataTransfer لحفظ الملفات في الـ input
            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            input.files = dt.files;

            files.forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'relative w-fit';

                const displayIndex = input.multiple ? index : 0;

                div.innerHTML = `
            <img src="${URL.createObjectURL(file)}"
                 class="h-24 w-24 object-cover rounded">
            <button type="button"
                    class="remove-new absolute -top-2 -right-2 bg-danger text-white w-6 h-6 rounded-full"
                    data-index="${displayIndex}"
                    data-input-id="${input.id}">
                ×
            </button>
        `;
                preview.appendChild(div);
            });
        }

        /* ================= REMOVE LOGIC ================= */
        document.addEventListener('click', function(e) {

            /* ---- remove existing photo ---- */
            if (e.target.classList.contains('remove-existing-photo')) {
                document.getElementById('existing-photo')?.remove();
                document.getElementById('remove_photo').value = 1;
                return;
            }

            /* ---- remove existing gallery ---- */
            if (e.target.classList.contains('remove-existing-gallery')) {
                const index = e.target.dataset.index;
                const path = e.target.dataset.path;

                document.getElementById('existing_gallery_' + index)?.remove();

                const input = document.getElementById('removed_gallery');
                const data = JSON.parse(input.value);
                data.push(path);
                input.value = JSON.stringify(data);
                return;
            }

            /* ================= REMOVE NEW UPLOADED FILE ================= */
            if (e.target.classList.contains('remove-new')) {
                const index = +e.target.dataset.index;
                const inputId = e.target.dataset.inputId;
                const input = document.getElementById(inputId);
                if (!input) return;

                const preview = document.getElementById('preview-' + inputId);
                if (!preview) return;


                const dt = new DataTransfer();
                [...input.files].forEach((file, i) => {
                    if (i !== index) dt.items.add(file);
                });

                input.files = dt.files;
                renderFiles(input, preview);
            }
        });
    });
</script>

<script>
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => {
        document.addEventListener(e, ev => {
            ev.preventDefault();
            ev.stopPropagation();
        });
    });

    document.querySelectorAll('.dropzone').forEach(zone => {
        const input = document.getElementById(zone.dataset.input);
        const preview = document.getElementById('preview-' + zone.dataset.input);
        zone.addEventListener('click', () => input.click());
        ['dragenter', 'dragover'].forEach(e =>
            zone.addEventListener(e, () => zone.classList.add('drag'))
        );
        ['dragleave', 'drop'].forEach(e =>
            zone.addEventListener(e, () => zone.classList.remove('drag'))
        );
        zone.addEventListener('drop', e => {
            zone.classList.remove('drag');
            input.files = e.dataTransfer.files;
            renderFiles(input, preview);
        });

        input.addEventListener('change', () => renderFiles(input, preview));
    });

    function formatFileSize(bytes) {
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        if (!bytes) return '0 Bytes';
        const i = Math.floor(Math.log(bytes) / Math.log(1024));
        return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
    }

    function renderFiles(input, preview) {
        preview.innerHTML = '';
        preview.classList.remove('hidden');

        const dt = new DataTransfer();

        [...input.files].forEach((file, index) => {
            dt.items.add(file);

            const div = document.createElement('div');
            div.className = 'relative border-custom rounded-lg p-3 text-center';

            div.innerHTML = `
                ${file.type.startsWith('image')
                    ? `<img src="${URL.createObjectURL(file)}" class="rounded-lg shadow-md w-full h-24 object-cover mb-2">`
                    : `<i class="ki-filled ki-file text-3xl text-gray-300"></i>`
                }
                <button type="button" class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center" data-index="${index}">x</button>
                <div class="text-xs mt-1 truncate">${file.name}</div>
                <div class="text-xs text-gray-300">${formatFileSize(file.size)}</div>
            `;

            preview.appendChild(div);
        });
    }

    // Handle delete buttons - both new files and existing images
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('button[data-index]');
        if (!btn) return;

        e.preventDefault();

        const preview = btn.closest('[id^="preview-"]');
        if (!preview) return;

        const inputId = preview.id.replace('preview-', '');
        const input = document.getElementById(inputId);

        // 🟢 حالة الصورة الرئيسية القديمة (Main Image - Edit Mode)
        if (btn.closest('#existing_main_image')) {
            const mainImageDiv = document.getElementById('existing_main_image');
            if (mainImageDiv) {
                mainImageDiv.remove();
                const removeInput = document.getElementById('remove_main_image');
                if (removeInput) {
                    removeInput.value = '1';
                }
            }
            return;
        }

        // 🟢 صور المعرض القديمة (Gallery Images - Edit Mode)
        const existingGalleryMatch = btn.closest('[id^="existing_gallery_"]');
        if (existingGalleryMatch) {
            const index = existingGalleryMatch.id.replace('existing_gallery_', '');
            const galleryDiv = document.getElementById('existing_gallery_' + index);
            if (galleryDiv) {
                galleryDiv.remove();

                // Create or update hidden input to track removed images
                let removedInput = document.getElementById('remove_gallery_images');
                if (!removedInput) {
                    removedInput = document.createElement('input');
                    removedInput.type = 'hidden';
                    removedInput.id = 'remove_gallery_images';
                    removedInput.name = 'remove_gallery_images';
                    removedInput.value = '[]';
                    document.querySelector('form').appendChild(removedInput);
                }

                let removed = JSON.parse(removedInput.value);
                if (!removed.includes(index)) {
                    removed.push(index);
                    removedInput.value = JSON.stringify(removed);
                }
            }
            return;
        }

        // 🟢 صور مضافة حديثًا (New Files)
        const removeIndex = +btn.dataset.index;
        const newDT = new DataTransfer();

        [...input.files].forEach((file, i) => {
            if (i !== removeIndex) newDT.items.add(file);
        });

        input.files = newDT.files;

        if (input.files.length) {
            renderFiles(input, preview);
        } else {
            preview.classList.add('hidden');
            preview.innerHTML = '';
        }
    });

    // Track removed gallery images
    let removedGalleryImages = [];

    // Remove existing main image
    function removeExistingMainImage() {
        document.getElementById('existing_main_image').style.display = 'none';
        document.getElementById('remove_main_image').value = '1';
    }

    // Remove existing gallery image
    function removeExistingGalleryImage(index, imagePath) {
        document.getElementById('existing_gallery_' + index).style.display = 'none';
        removedGalleryImages.push(imagePath);
        document.getElementById('remove_gallery_images').value = JSON.stringify(removedGalleryImages);
    }
</script>

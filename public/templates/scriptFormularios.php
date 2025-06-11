<script>
    $(document).ready(function () {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
            allowClear: true
        });

        tinymce.init({
            selector: '#instrucciones',
            promotion: false,
            branding: false,
            language: 'es',
            language_url: '<?php echo baseUrl(); ?>/assets/libs/tinymce/js/tinymce/langs/es.js',
            height: 316,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
                'anchor', 'searchreplace', 'visualblocks', 'code',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat ',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                    $("#instrucciones").valid();
                });
            }
        });

        const inputs = [
            { inputId: 'imagen1', previewId: 'imagen-1-preview' },
            { inputId: 'imagen2', previewId: 'imagen-2-preview' }
        ];

        inputs.forEach(item => {
            const input = document.getElementById(item.inputId);
            const preview = document.getElementById(item.previewId);

            input.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        preview.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    });
</script>
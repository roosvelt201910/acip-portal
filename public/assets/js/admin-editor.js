/**
 * ACIP Admin - Shared CKEditor 5 Configuration
 * Uses the UMD build from CDN as used in Programas module.
 */

document.addEventListener('DOMContentLoaded', function () {
    // Check if CKEDITOR is available
    if (typeof CKEDITOR === 'undefined') {
        // If not loaded yet, wait or do nothing (views should include it)
        return;
    }

    // Extract plugins from global CKEDITOR object
    // Safely extract plugins
    const {
        ClassicEditor,
        SourceEditing, Essentials, Bold, Italic, Underline, Strikethrough,
        Heading, Link, List, BlockQuote, Table, TableToolbar, Paragraph,
        Undo, Indent, IndentBlock, Alignment,
        Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage,
        ImageInsert, MediaEmbed, SimpleUploadAdapter
    } = CKEDITOR;

    // Optional plugins (check if they exist)
    const ImageUpload = CKEDITOR.ImageUpload || null;
    const GeneralHtmlSupport = CKEDITOR.GeneralHtmlSupport || null;

    // Build plugin list dynamically
    const plugins = [
        SourceEditing, Essentials, Bold, Italic, Underline, Strikethrough,
        Heading, Link, List, BlockQuote, Table, TableToolbar, Paragraph,
        Undo, Indent, IndentBlock, Alignment,
        Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage,
        ImageInsert, MediaEmbed, SimpleUploadAdapter
    ];

    if (ImageUpload) {
        plugins.push(ImageUpload);
    }
    if (GeneralHtmlSupport) {
        plugins.push(GeneralHtmlSupport);
    }

    // Common Configuration
    const editorConfig = {
        licenseKey: 'GPL',
        plugins: plugins,
        toolbar: [
            'sourceEditing', '|',
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough', '|',
            'bulletedList', 'numberedList', '|',
            'alignment', 'outdent', 'indent', '|',
            'link', 'insertImage', 'mediaEmbed', 'blockQuote', 'insertTable', '|',
            'undo', 'redo'
        ],
        simpleUpload: {
            uploadUrl: '/web/acip-portal/public/admin/media/upload',
            // headers: { 'X-CSRF-TOKEN': '...' } // CSRF not strictly required for authenticated admin session cookie
        },
        // Allow all HTML tags via GeneralHtmlSupport
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        },
        image: {
            toolbar: [
                'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                'toggleImageCaption', 'imageTextAlternative'
            ],
            // Enable insert via URL and Upload
            insert: {
                integrations: ['upload', 'url']
            }
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        },
        language: 'es'
    };

    // Initialize all areas with class 'editor'
    document.querySelectorAll('.editor').forEach(textarea => {
        // Check if already initialized to match ID or avoid duplicates
        if (textarea.nextSibling && textarea.nextSibling.classList && textarea.nextSibling.classList.contains('ck')) {
            return;
        }

        ClassicEditor
            .create(textarea, editorConfig)
            .then(editor => {
                console.log('CKEditor initialized on:', textarea.getAttribute('name'));

                // Update textarea on change for basic form submission
                editor.model.document.on('change:data', () => {
                    textarea.value = editor.getData();
                });
            })
            .catch(error => {
                console.error('Error initializing editor:', error);
            });
    });
});

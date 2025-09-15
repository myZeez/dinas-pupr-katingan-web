// Quill.js Fallback - Simple Rich Text Editor
class SimpleQuill {
    constructor(selector, options = {}) {
        this.container = document.querySelector(selector);
        this.options = options;
        this.content = '';
        this.init();
    }

    init() {
        this.createEditor();
        this.createToolbar();
        this.bindEvents();
    }

    createEditor() {
        this.container.innerHTML = `
            <div class="simple-toolbar">
                <button type="button" data-command="bold" title="Bold"><b>B</b></button>
                <button type="button" data-command="italic" title="Italic"><i>I</i></button>
                <button type="button" data-command="underline" title="Underline"><u>U</u></button>
                <button type="button" data-command="insertOrderedList" title="Numbered List">1.</button>
                <button type="button" data-command="insertUnorderedList" title="Bullet List">•</button>
                <button type="button" data-command="justifyLeft" title="Align Left">←</button>
                <button type="button" data-command="justifyCenter" title="Align Center">↔</button>
                <button type="button" data-command="justifyRight" title="Align Right">→</button>
            </div>
            <div class="simple-editor" contenteditable="true" style="
                min-height: 500px;
                padding: 24px;
                border: 1px solid #e2e8f0;
                border-radius: 0 0 12px 12px;
                outline: none;
                font-size: 16px;
                line-height: 1.6;
                background: white;
            ">${this.options.placeholder || 'Start writing...'}</div>
        `;

        this.editor = this.container.querySelector('.simple-editor');
        this.toolbar = this.container.querySelector('.simple-toolbar');
    }

    createToolbar() {
        const style = document.createElement('style');
        style.textContent = `
            .simple-toolbar {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 12px 12px 0 0;
                padding: 12px;
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }
            .simple-toolbar button {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 6px;
                padding: 8px 12px;
                cursor: pointer;
                font-size: 14px;
                transition: all 0.2s;
            }
            .simple-toolbar button:hover {
                background: #e2e8f0;
            }
            .simple-toolbar button.active {
                background: #667eea;
                color: white;
                border-color: #667eea;
            }
        `;
        document.head.appendChild(style);
    }

    bindEvents() {
        this.toolbar.addEventListener('click', (e) => {
            if (e.target.tagName === 'BUTTON') {
                e.preventDefault();
                const command = e.target.dataset.command;
                document.execCommand(command, false, null);
                this.updateContent();
            }
        });

        this.editor.addEventListener('input', () => {
            this.updateContent();
        });

        this.editor.addEventListener('focus', () => {
            if (this.editor.textContent.trim() === this.options.placeholder) {
                this.editor.innerHTML = '';
            }
        });
    }

    updateContent() {
        this.content = this.editor.innerHTML;
        if (this.options.onChange) {
            this.options.onChange();
        }
    }

    setContents(content) {
        this.editor.innerHTML = content;
        this.updateContent();
    }

    on(event, callback) {
        if (event === 'text-change') {
            this.options.onChange = callback;
        }
    }

    get root() {
        return {
            innerHTML: this.editor.innerHTML
        };
    }
}

// Make it compatible with Quill API
window.Quill = SimpleQuill;

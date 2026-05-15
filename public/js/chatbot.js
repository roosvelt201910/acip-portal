/**
 * ACIP Chatbot - Sistema de Asistencia Interactiva
 * Ayuda a los visitantes a navegar por el portal y entender los procesos
 */

class ACIPChatbot {
    constructor() {
        this.isOpen = false;
        this.conversationHistory = [];
        this.currentContext = null;
        this.init();
    }

    init() {
        this.injectHTML();
        this.attachEventListeners();
        this.showWelcomeMessage();
    }

    injectHTML() {
        const chatbotHTML = `
            <div id="acip-chatbot">
                <!-- Widget flotante -->
                <div class="chatbot-widget" id="chatbotWidget">
                    <i class="fas fa-comments"></i>
                    <div class="chat-badge">1</div>
                </div>

                <!-- Ventana de chat -->
                <div class="chatbot-window" id="chatbotWindow">
                    <div class="chatbot-header">
                        <div class="chatbot-header-content">
                            <div class="chatbot-avatar">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div class="chatbot-title">
                                <h4>Asistente Virtual ACIP</h4>
                                <span class="chatbot-status">En línea</span>
                            </div>
                        </div>
                        <button class="chatbot-close" id="chatbotClose">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="chatbot-messages" id="chatbotMessages">
                        <!-- Los mensajes se insertarán aquí -->
                    </div>

                    <div class="chatbot-quick-options" id="chatbotQuickOptions">
                        <!-- Las opciones rápidas se insertarán aquí -->
                    </div>

                    <div class="chatbot-input-area">
                        <input 
                            type="text" 
                            class="chatbot-input" 
                            id="chatbotInput" 
                            placeholder="Escribe tu pregunta..."
                            autocomplete="off"
                        >
                        <button class="chatbot-send" id="chatbotSend">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', chatbotHTML);
    }

    attachEventListeners() {
        const widget = document.getElementById('chatbotWidget');
        const closeBtn = document.getElementById('chatbotClose');
        const sendBtn = document.getElementById('chatbotSend');
        const input = document.getElementById('chatbotInput');

        widget.addEventListener('click', () => this.toggleChat());
        closeBtn.addEventListener('click', () => this.toggleChat());
        sendBtn.addEventListener('click', () => this.sendMessage());
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.sendMessage();
        });
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        const window = document.getElementById('chatbotWindow');
        const widget = document.getElementById('chatbotWidget');
        const badge = widget.querySelector('.chat-badge');

        if (this.isOpen) {
            window.classList.add('active');
            widget.classList.add('hidden');
            if (badge) badge.style.display = 'none';
            document.getElementById('chatbotInput').focus();
        } else {
            window.classList.remove('active');
            widget.classList.remove('hidden');
        }
    }

    showWelcomeMessage() {
        setTimeout(() => {
            this.addBotMessage(
                '¡Hola! 👋 Soy tu asistente virtual del Instituto ACIP. Estoy aquí para ayudarte a navegar por nuestro portal y resolver tus dudas.',
                true
            );
            this.showQuickOptions([
                { text: '📚 Programas Académicos', action: 'programas' },
                { text: '📝 Admisión', action: 'admision' },
                { text: '💳 Matrícula', action: 'matricula' },
                { text: '🎓 Becas', action: 'becas' },
                { text: '📞 Contacto', action: 'contacto' }
            ]);
        }, 1000);
    }

    addBotMessage(message, skipTyping = false) {
        const messagesContainer = document.getElementById('chatbotMessages');

        if (!skipTyping) {
            this.showTypingIndicator();
        }

        setTimeout(() => {
            this.hideTypingIndicator();

            const messageDiv = document.createElement('div');
            messageDiv.className = 'chat-message bot-message';
            messageDiv.innerHTML = `
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-bubble">
                    ${message}
                </div>
            `;

            messagesContainer.appendChild(messageDiv);
            this.scrollToBottom();
        }, skipTyping ? 0 : 1000);
    }

    addUserMessage(message) {
        const messagesContainer = document.getElementById('chatbotMessages');

        const messageDiv = document.createElement('div');
        messageDiv.className = 'chat-message user-message';
        messageDiv.innerHTML = `
            <div class="message-bubble">
                ${this.escapeHtml(message)}
            </div>
        `;

        messagesContainer.appendChild(messageDiv);
        this.scrollToBottom();
    }

    showTypingIndicator() {
        const messagesContainer = document.getElementById('chatbotMessages');
        const typingDiv = document.createElement('div');
        typingDiv.className = 'chat-message bot-message typing-indicator';
        typingDiv.id = 'typingIndicator';
        typingDiv.innerHTML = `
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="message-bubble">
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        `;
        messagesContainer.appendChild(typingDiv);
        this.scrollToBottom();
    }

    hideTypingIndicator() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) {
            indicator.remove();
        }
    }

    showQuickOptions(options) {
        const optionsContainer = document.getElementById('chatbotQuickOptions');
        optionsContainer.innerHTML = '';

        options.forEach(option => {
            const button = document.createElement('button');
            button.className = 'quick-option-btn';
            button.textContent = option.text;
            button.addEventListener('click', () => {
                this.handleQuickOption(option.action, option.text);
            });
            optionsContainer.appendChild(button);
        });
    }

    handleQuickOption(action, text) {
        this.addUserMessage(text);
        this.processMessage(action);
    }

    sendMessage() {
        const input = document.getElementById('chatbotInput');
        const message = input.value.trim();

        if (!message) return;

        this.addUserMessage(message);
        input.value = '';

        this.processMessage(message);
    }

    processMessage(message) {
        const lowerMessage = message.toLowerCase();
        let response = null;
        let quickOptions = null;

        // Base de conocimientos
        const knowledgeBase = {
            // Admisión
            admision: {
                keywords: ['admision', 'admisión', 'postular', 'inscribir', 'inscripcion', 'inscripción', 'requisitos admision'],
                response: `
                    <strong>📝 Proceso de Admisión</strong><br><br>
                    Para postular al Instituto ACIP debes seguir estos pasos:<br><br>
                    <strong>1. Requisitos:</strong><br>
                    • Certificado de estudios original<br>
                    • DNI (copia)<br>
                    • Partida de nacimiento<br>
                    • 2 fotos tamaño carnet<br><br>
                    <strong>2. Proceso:</strong><br>
                    • Presentar documentación<br>
                    • Evaluación académica<br>
                    • Entrevista personal<br>
                    • Publicación de resultados<br><br>
                    ¿Quieres más información sobre algún paso específico?
                `,
                options: [
                    { text: '📄 Documentos necesarios', action: 'documentos_admision' },
                    { text: '💰 Costos de admisión', action: 'costos_admision' },
                    { text: '📅 Fechas importantes', action: 'fechas_admision' }
                ]
            },

            documentos_admision: {
                keywords: ['documentos admision', 'papeles', 'certificado'],
                response: `
                    <strong>📄 Documentos para Admisión</strong><br><br>
                    Necesitas presentar:<br><br>
                    ✅ Certificado de estudios (original)<br>
                    ✅ DNI vigente (copia simple)<br>
                    ✅ Partida de nacimiento (copia certificada)<br>
                    ✅ 2 fotografías tamaño carnet a color<br>
                    ✅ Recibo de pago por derecho de admisión<br><br>
                    Todos los documentos deben presentarse en la oficina de admisión.
                `,
                options: [
                    { text: '🏢 ¿Dónde presentar?', action: 'contacto' },
                    { text: '💳 Proceso de matrícula', action: 'matricula' },
                    { text: '🔙 Volver al menú', action: 'menu' }
                ]
            },

            // Matrícula
            matricula: {
                keywords: ['matricula', 'matrícula', 'matricular', 'inscribir', 'costo matricula', 'pago matricula'],
                response: `
                    <strong>💳 Proceso de Matrícula</strong><br><br>
                    Una vez aceptado, sigue estos pasos:<br><br>
                    <strong>1. Documentación:</strong><br>
                    • Ficha de matrícula (proporcionada por el instituto)<br>
                    • Certificado de estudios legalizado<br>
                    • Voucher de pago<br><br>
                    <strong>2. Pagos:</strong><br>
                    • Derecho de matrícula<br>
                    • Primera cuota de pensión<br><br>
                    <strong>3. Finalización:</strong><br>
                    • Entrega de documentos en ventanilla<br>
                    • Recepción de carné universitario<br>
                    • Acceso al sistema académico<br><br>
                    ¿Necesitas información específica?
                `,
                options: [
                    { text: '💰 Costos de matrícula', action: 'costos_matricula' },
                    { text: '📅 Plazos de matrícula', action: 'plazos_matricula' },
                    { text: '🎓 Becas disponibles', action: 'becas' }
                ]
            },

            // Programas
            programas: {
                keywords: ['programas', 'carreras', 'cursos', 'que estudiar', 'oferta academica', 'académica'],
                response: `
                    <strong>📚 Programas Académicos</strong><br><br>
                    El Instituto ACIP ofrece diversos programas de educación superior:<br><br>
                    • Programas Técnicos (3 años)<br>
                    • Programas Profesionales (4-5 años)<br>
                    • Cursos de especialización<br>
                    • Programas de actualización<br><br>
                    Todos nuestros programas están acreditados y tienen convenios con empresas para prácticas profesionales.<br><br>
                    <a href="${window.location.origin}/web/acip-portal/public/programas" style="color: #4f46e5; text-decoration: underline;">Ver todos los programas</a>
                `,
                options: [
                    { text: '⏱️ Duración de programas', action: 'duracion_programas' },
                    { text: '🏆 Certificaciones', action: 'certificaciones' },
                    { text: '👨‍🏫 Plana docente', action: 'docentes' }
                ]
            },

            // Becas
            becas: {
                keywords: ['beca', 'becas', 'descuento', 'ayuda economica', 'económica'],
                response: `
                    <strong>🎓 Becas y Beneficios</strong><br><br>
                    El Instituto ACIP ofrece diversas modalidades de becas:<br><br>
                    <strong>Becas por:</strong><br>
                    • Excelencia académica (hasta 100%)<br>
                    • Mérito deportivo (hasta 50%)<br>
                    • Situación socioeconómica (hasta 75%)<br>
                    • Primer puesto (100%)<br><br>
                    <strong>Requisitos generales:</strong><br>
                    • Promedio mínimo de 14<br>
                    • Documentación sustentadora<br>
                    • Entrevista personal<br><br>
                    Las becas se renuevan semestralmente según rendimiento.
                `,
                options: [
                    { text: '📋 Requisitos de becas', action: 'requisitos_becas' },
                    { text: '📝 Cómo postular', action: 'postular_becas' },
                    { text: '💳 Proceso de matrícula', action: 'matricula' }
                ]
            },

            // Plana Docente
            docentes: {
                keywords: ['docente', 'docentes', 'profesor', 'profesores', 'maestro', 'plana'],
                response: `
                    <strong>👨‍🏫 Plana Docente</strong><br><br>
                    Contamos con profesionales altamente capacitados:<br><br>
                    • Docentes con grado de maestría y doctorado<br>
                    • Profesionales en actividad<br>
                    • Especialistas en sus áreas<br>
                    • Capacitación continua<br><br>
                    <a href="${window.location.origin}/web/acip-portal/public/plana-docente" style="color: #4f46e5; text-decoration: underline;">Conoce a nuestros docentes</a>
                `,
                options: [
                    { text: '📚 Ver programas', action: 'programas' },
                    { text: '📞 Contactar', action: 'contacto' },
                    { text: '🔙 Menú principal', action: 'menu' }
                ]
            },

            // Contacto
            contacto: {
                keywords: ['contacto', 'telefono', 'teléfono', 'direccion', 'dirección', 'ubicacion', 'ubicación', 'donde', 'dónde'],
                response: `
                    <strong>📞 Información de Contacto</strong><br><br>
                    <strong>Dirección:</strong><br>
                    ${this.getSiteConfig('site_direccion', 'Consultar en la página')}<br><br>
                    <strong>Teléfono:</strong><br>
                    ${this.getSiteConfig('site_phone', 'Consultar en la página')}<br><br>
                    <strong>Email:</strong><br>
                    ${this.getSiteConfig('site_email', 'contacto@acip.edu.pe')}<br><br>
                    <strong>Horario:</strong><br>
                    ${this.getSiteConfig('site_horario', 'Lun - Vie: 8:00 AM - 6:00 PM')}<br><br>
                    <a href="${window.location.origin}/web/acip-portal/public/contacto" style="color: #4f46e5; text-decoration: underline;">Enviar mensaje</a>
                `,
                options: [
                    { text: '🗺️ Ver mapa', action: 'mapa' },
                    { text: '📝 Formulario contacto', action: 'formulario_contacto' },
                    { text: '🔙 Volver al menú', action: 'menu' }
                ]
            },

            // Eventos y Noticias
            eventos: {
                keywords: ['evento', 'eventos', 'actividad', 'actividades'],
                response: `
                    <strong>📅 Eventos</strong><br><br>
                    Mantente informado sobre nuestros eventos académicos, culturales y deportivos.<br><br>
                    <a href="${window.location.origin}/web/acip-portal/public/eventos" style="color: #4f46e5; text-decoration: underline;">Ver calendario de eventos</a>
                `,
                options: [
                    { text: '📰 Noticias', action: 'noticias' },
                    { text: '🔙 Menú principal', action: 'menu' }
                ]
            },

            noticias: {
                keywords: ['noticia', 'noticias', 'novedad', 'novedades', 'comunicado'],
                response: `
                    <strong>📰 Noticias</strong><br><br>
                    Mantente al día con las últimas noticias y comunicados del instituto.<br><br>
                    <a href="${window.location.origin}/web/acip-portal/public/noticias" style="color: #4f46e5; text-decoration: underline;">Ver todas las noticias</a>
                `,
                options: [
                    { text: '📅 Eventos', action: 'eventos' },
                    { text: '🔙 Menú principal', action: 'menu' }
                ]
            },

            // Menú principal
            menu: {
                keywords: ['menu', 'menú', 'inicio', 'principal', 'opciones', 'ayuda', 'hola'],
                response: `¿En qué puedo ayudarte hoy? Selecciona una opción:`,
                options: [
                    { text: '📚 Programas Académicos', action: 'programas' },
                    { text: '📝 Admisión', action: 'admision' },
                    { text: '💳 Matrícula', action: 'matricula' },
                    { text: '🎓 Becas', action: 'becas' },
                    { text: '📞 Contacto', action: 'contacto' }
                ]
            }
        };

        // Buscar respuesta basada en palabras clave
        for (const [key, data] of Object.entries(knowledgeBase)) {
            if (data.keywords.some(keyword => lowerMessage.includes(keyword))) {
                response = data.response;
                quickOptions = data.options;
                this.currentContext = key;
                break;
            }
        }

        // Respuesta por defecto
        if (!response) {
            response = `
                Lo siento, no entendí tu pregunta. 🤔<br><br>
                Puedo ayudarte con información sobre:<br>
                • Admisión y requisitos<br>
                • Matrícula y pagos<br>
                • Programas académicos<br>
                • Becas y beneficios<br>
                • Contacto y ubicación<br><br>
                ¿Sobre qué te gustaría saber?
            `;
            quickOptions = [
                { text: '📝 Admisión', action: 'admision' },
                { text: '💳 Matrícula', action: 'matricula' },
                { text: '📚 Programas', action: 'programas' },
                { text: '🎓 Becas', action: 'becas' }
            ];
        }

        this.addBotMessage(response);

        if (quickOptions) {
            setTimeout(() => {
                this.showQuickOptions(quickOptions);
            }, 1200);
        }
    }

    getSiteConfig(key, defaultValue) {
        // Intentar obtener configuración desde meta tags o variables globales
        const metaTag = document.querySelector(`meta[name="acip-${key}"]`);
        if (metaTag) {
            return metaTag.content;
        }
        return defaultValue;
    }

    scrollToBottom() {
        const messagesContainer = document.getElementById('chatbotMessages');
        setTimeout(() => {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }, 100);
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Inicializar el chatbot cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    const chatbot = new ACIPChatbot();
});

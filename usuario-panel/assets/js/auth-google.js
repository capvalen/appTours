/**
 * auth-google.js
 * ------------------------------------------------------------------
 * Inicializa Firebase y conecta los botones "Continuar con Google".
 *
 * Requiere que la página defina antes:
 *     <script>window.FIREBASE_CONFIG = { ... };</script>
 *
 * El botón de Google debe tener el atributo:  data-google-login
 * ------------------------------------------------------------------
 */
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-app.js';
import {
    getAuth,
    GoogleAuthProvider,
    signInWithPopup,
} from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-auth.js';

const cfg = window.FIREBASE_CONFIG;
const botones = document.querySelectorAll('[data-google-login]');

function mostrarError(mensaje) {
    const caja = document.getElementById('googleError');
    if (caja) {
        caja.textContent = mensaje;
        caja.classList.remove('d-none');
    } else {
        alert(mensaje);
    }
}

function ocultarError() {
    const caja = document.getElementById('googleError');
    if (caja) {
        caja.classList.add('d-none');
    }
}

if (!cfg || !cfg.apiKey || cfg.apiKey === 'TU_API_KEY') {
    botones.forEach((b) => {
        b.addEventListener('click', () => {
            mostrarError('Firebase aún no está configurado. Revisa php/firebase_config.php');
        });
    });
} else {
    const app = initializeApp(cfg);
    const auth = getAuth(app);
    const provider = new GoogleAuthProvider();
    provider.setCustomParameters({ prompt: 'select_account' });

    botones.forEach((boton) => {
        boton.addEventListener('click', async () => {
            ocultarError();
            const textoOriginal = boton.innerHTML;
            boton.disabled = true;

            try {
                const resultado = await signInWithPopup(auth, provider);
                const idToken = await resultado.user.getIdToken();

                const endpoint = boton.dataset.endpoint || 'php/google_login.php';
                const respuesta = await fetch(endpoint, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ idToken }),
                });

                const data = await respuesta.json();

                if (data.ok && data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }
                mostrarError(data.error || 'No se pudo iniciar sesión con Google.');
            } catch (e) {
                // El usuario cerró la ventana o canceló
                if (e && (e.code === 'auth/popup-closed-by-user' || e.code === 'auth/cancelled-popup-request')) {
                    // silencioso
                } else if (e && e.code === 'auth/unauthorized-domain') {
                    mostrarError('Este dominio no está autorizado en Firebase Authentication.');
                } else {
                    mostrarError('No se pudo completar el inicio de sesión con Google.');
                }
            } finally {
                boton.disabled = false;
                boton.innerHTML = textoOriginal;
            }
        });
    });
}

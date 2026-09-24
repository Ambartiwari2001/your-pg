import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

window.Alpine = Alpine;
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
    showCloseButton: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

window.Toast = Toast;

window.showToast = (message, icon = 'success') => {
    Toast.fire({
        icon: icon,
        title: message
    });
};

window.showAlert = (title, message, icon = 'info') => {
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        confirmButtonColor: '#4f46e5',
        customClass: {
            popup: 'rounded-2xl shadow-2xl',
            confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-white bg-brand-600 hover:bg-brand-700'
        }
    });
};

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );

    document.querySelectorAll('.animate-on-scroll').forEach((el) => observer.observe(el));

    document.querySelectorAll('[data-gallery-thumb]').forEach((thumb) => {
        thumb.addEventListener('click', () => {
            const main = document.getElementById('mainImage');
            if (main) {
                main.src = thumb.dataset.galleryThumb;
                main.classList.add('animate-scale-in');
                setTimeout(() => main.classList.remove('animate-scale-in'), 500);
            }
            document.querySelectorAll('[data-gallery-thumb]').forEach((t) => {
                t.classList.remove('ring-2', 'ring-brand-500');
            });
            thumb.classList.add('ring-2', 'ring-brand-500');
        });
    });

    // Universal SweetAlert confirmation dialog for forms and buttons
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-confirm], [data-confirm-delete], .confirm-delete');
        if (trigger) {
            e.preventDefault();
            const form = trigger.closest('form');
            const isDelete = trigger.hasAttribute('data-confirm-delete') || trigger.classList.contains('confirm-delete') || trigger.dataset.type === 'delete';
            const message = trigger.getAttribute('data-confirm') || trigger.getAttribute('data-confirm-delete') || 'Are you sure you want to proceed? This action cannot be undone.';
            const title = trigger.getAttribute('data-title') || (isDelete ? 'Confirm Deletion' : 'Are you sure?');
            const confirmText = trigger.getAttribute('data-confirm-text') || (isDelete ? 'Yes, Delete' : 'Yes, Proceed');
            const cancelText = trigger.getAttribute('data-cancel-text') || 'Cancel';

            Swal.fire({
                title: title,
                text: message,
                icon: isDelete ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: isDelete ? '#ef4444' : '#4f46e5',
                cancelButtonColor: '#64748b',
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-6',
                    title: 'text-xl font-bold text-slate-900',
                    htmlContainer: 'text-slate-600 text-sm mt-2',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-semibold text-white shadow-sm transition-all duration-200',
                    cancelButton: 'px-5 py-2.5 rounded-xl font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-all duration-200'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (form) {
                        form.submit();
                    } else if (trigger.tagName === 'A' && trigger.href) {
                        window.location.href = trigger.href;
                    }
                }
            });
        }
    });
});

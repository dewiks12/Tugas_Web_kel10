<!-- Bubble Animation -->
<div class="fixed inset-0 -z-10 overflow-hidden">
    <div class="bubbles">
        @for ($i = 0; $i < 20; $i++)
            <div class="bubble"></div>
        @endfor
    </div>
</div>

<style>
.bubbles {
    position: relative;
    width: 100%;
    height: 100%;
}

.bubble {
    position: absolute;
    left: var(--bubble-left-offset);
    bottom: -75%;
    display: block;
    width: var(--bubble-radius);
    height: var(--bubble-radius);
    border-radius: 50%;
    animation: float-up var(--bubble-float-duration) var(--bubble-float-delay) ease-in infinite;
    background: radial-gradient(circle at center, rgba(193, 163, 255, 0.2) 0%, rgba(193, 163, 255, 0.1) 100%);
}

.bubble::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: radial-gradient(circle at center, rgba(193, 163, 255, 0.3) 0%, rgba(193, 163, 255, 0) 100%);
}

@keyframes float-up {
    from {
        transform: translateY(0) scale(1);
    }
    to {
        transform: translateY(-800px) scale(0);
    }
}

.bubble:nth-child(1) { --bubble-left-offset: 5%; --bubble-radius: 63px; --bubble-float-duration: 12s; --bubble-float-delay: 0s; }
.bubble:nth-child(2) { --bubble-left-offset: 15%; --bubble-radius: 45px; --bubble-float-duration: 16s; --bubble-float-delay: 1s; }
.bubble:nth-child(3) { --bubble-left-offset: 25%; --bubble-radius: 55px; --bubble-float-duration: 14s; --bubble-float-delay: 2s; }
.bubble:nth-child(4) { --bubble-left-offset: 35%; --bubble-radius: 65px; --bubble-float-duration: 18s; --bubble-float-delay: 3s; }
.bubble:nth-child(5) { --bubble-left-offset: 45%; --bubble-radius: 35px; --bubble-float-duration: 15s; --bubble-float-delay: 4s; }
.bubble:nth-child(6) { --bubble-left-offset: 55%; --bubble-radius: 50px; --bubble-float-duration: 13s; --bubble-float-delay: 5s; }
.bubble:nth-child(7) { --bubble-left-offset: 65%; --bubble-radius: 40px; --bubble-float-duration: 17s; --bubble-float-delay: 6s; }
.bubble:nth-child(8) { --bubble-left-offset: 75%; --bubble-radius: 60px; --bubble-float-duration: 14s; --bubble-float-delay: 7s; }
.bubble:nth-child(9) { --bubble-left-offset: 85%; --bubble-radius: 45px; --bubble-float-duration: 15s; --bubble-float-delay: 8s; }
.bubble:nth-child(10) { --bubble-left-offset: 95%; --bubble-radius: 55px; --bubble-float-duration: 16s; --bubble-float-delay: 9s; }
.bubble:nth-child(11) { --bubble-left-offset: 10%; --bubble-radius: 40px; --bubble-float-duration: 13s; --bubble-float-delay: 10s; }
.bubble:nth-child(12) { --bubble-left-offset: 20%; --bubble-radius: 50px; --bubble-float-duration: 17s; --bubble-float-delay: 11s; }
.bubble:nth-child(13) { --bubble-left-offset: 30%; --bubble-radius: 45px; --bubble-float-duration: 15s; --bubble-float-delay: 12s; }
.bubble:nth-child(14) { --bubble-left-offset: 40%; --bubble-radius: 55px; --bubble-float-duration: 14s; --bubble-float-delay: 13s; }
.bubble:nth-child(15) { --bubble-left-offset: 50%; --bubble-radius: 65px; --bubble-float-duration: 16s; --bubble-float-delay: 14s; }
.bubble:nth-child(16) { --bubble-left-offset: 60%; --bubble-radius: 40px; --bubble-float-duration: 13s; --bubble-float-delay: 15s; }
.bubble:nth-child(17) { --bubble-left-offset: 70%; --bubble-radius: 50px; --bubble-float-duration: 17s; --bubble-float-delay: 16s; }
.bubble:nth-child(18) { --bubble-left-offset: 80%; --bubble-radius: 45px; --bubble-float-duration: 15s; --bubble-float-delay: 17s; }
.bubble:nth-child(19) { --bubble-left-offset: 90%; --bubble-radius: 55px; --bubble-float-duration: 14s; --bubble-float-delay: 18s; }
.bubble:nth-child(20) { --bubble-left-offset: 100%; --bubble-radius: 60px; --bubble-float-duration: 16s; --bubble-float-delay: 19s; }
</style> 
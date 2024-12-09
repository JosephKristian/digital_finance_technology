@if (session('error') || session('success'))
    <div id="notification" class="notification-custom text-center">
        <div class="container-custom">
            @if (session('error'))
                <div class="box-custom">
                    <div class="dot-custom dot-error-custom"></div>
                    <div class="face-error-custom">
                        <div class="crossmark"></div>
                    </div>
                    <div class="face2-custom">
                        <div class="loader-custom">
                            <span></span>
                            <div class="eye-custom"></div>
                            <span></span>
                            <div class="eye-custom right"></div>
                            <span></span>
                            <div class="mouth-custom mouth-sad-custom"></div>
                        </div>
                    </div>
                    <div class="shadow-custom"></div>
                    <div class="message-custom">
                        <h1>Maaf terjadi sesuatu :(</h1>
                        <p>{{ session('error') }}</p>
                    </div>
                    <button class="button-custom">
                        <h1 class="red-custom">coba lagi</h1>
                    </button>
                </div>
            @elseif (session('success'))
                <div class="box-custom">
                    <div class="dot-custom dot-success-custom"></div>
                    <div class="face-success-custom">
                        <div class="checkmark"></div>
                    </div>
                    <div class="face-custom">
                        <div class="loader-custom">
                            <span></span>
                            <div class="eye-custom"></div>
                            <span></span>
                            <div class="eye-custom right"></div>
                            <span></span>
                            <div class="mouth-custom mouth-happy-custom"></div>
                        </div>
                    </div>
                    <div class="shadow-custom"></div>
                    <div class="message-custom">
                        <h1>Keren! Berhasil!!!</h1>
                        <p>{{ session('success') }}</p>
                    </div>
                    <button class="button-custom">
                        <h1 class="green-custom">lanjutkan</h1>
                    </button>
                </div>
            @endif
        </div>
    </div>
@endif

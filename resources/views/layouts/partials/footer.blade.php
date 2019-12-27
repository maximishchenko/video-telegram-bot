<footer>
    <div class="container">
        <div class="border-top pt-3">
            <p class="float-left">
                &copy; {{ date('Y') }} - <a href="mailto://{{ config('app.developer', 'info@contoso.com') }}">
                    {{ config('app.developer', 'info@contoso.com') }}
                </a>
            </p>
            <p class="float-right">
                {{ config('app.name', 'Laravel') }}
            </p>
        </div>
    </div>
</footer>

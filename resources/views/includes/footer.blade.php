<footer class="text-light mt-5" style="background: #7a42ce;">
  <div class="container text-center text-md-left py-5">
    <div class="row my-4">
      <div class="col-md-3 col-lg-4 col-xl-3 text-lightgray mb-md-0 mb-3">
        <div class="mb-3">
          <img
            src="{{ asset('img/logo.png') }}"
            width="100"
            class="d-inline-block align-top"
            style="border-radius: 30px;"
            alt=""
          >
        </div>

        <p class="small">
          {{ __('interface.footer') }}
        </p>
        <p class="small">
          &copy;
          {{ date("Y") }}
          {{ config('app.name') }}
        </p>
      </div>

      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-md-0 mb-4" style="font-size: 15px;">
        <p class="text-uppercase font-weight-bold mb-3">{{ __('interface.actions') }}</p>
        <p><a href="{{ route('contact') }}" class="text-lightgray">{{ __('interface.contact_us') }}</a></p>
        <p><a href="{{ route('login') }}" class="text-lightgray">{{ __('interface.login') }}</a></p>
        <p><a href="{{ route('register') }}" class="text-lightgray">{{ __('interface.register') }}</a></p>
      </div>

      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-md-0 mb-4" style="font-size: 15px;">
        <p class="text-uppercase font-weight-bold mb-3">{{ __('interface.info') }}</p>
        <p><a href="{{ route('privacy') }}" class="text-lightgray">{{ __('policy.privacy') }}</a></p>
        <p><a href="{{ route('cookies') }}" class="text-lightgray">{{ __('policy.cookies') }}</a></p>
        <p><a href="{{ route('terms') }}" class="text-lightgray">{{ __('policy.terms') }}</a></p>
      </div>

      <div class="col-md-4 col-lg-3 col-xl-3 text-md-right mb-md-0 mb-4" style="font-size: 15px;">
        <p class="text-uppercase font-weight-bold mb-3">{{ __('interface.social') }}</p>
        <div class="text-lightgray">
          <div class="text-center text-md-right mb-3">
            <a href="#" class="text-lightgray text-decoration-none" target="_blank">
              <i class="fab fa-facebook-f"></i>
            </a>

            <a href="#" class="text-lightgray text-decoration-none ml-3" target="_blank">
              <i class="fab fa-twitter white-text"></i>
            </a>

            @if (app()->currentLocale() === 'ru')
              <a href="#" class="text-lightgray text-decoration-none ml-3" target="_blank">
                <i class="fab fa-vk white-text"></i>
              </a>
            @endif
          </div>

          <p class="font-weight-bold">
            <i class="far fa-envelope ml-2"></i>
            {{ config('mail.from.address') }}
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

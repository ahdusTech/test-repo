<script>
    setTimeout(() => {
        COOKIEFLOW.init({
            preferences: {
                intro: "{!!__('messages.cookie_intro')!!}",
                settings_intro: "{!!__('messages.cookie_settings_intro')!!}",
                all_cookies_label: "{{__('messages.select_all')}}",
                all_cookies_button: "{{__('messages.i_aggree')}}",
                button_class: 'btn btn-success',
                groups: [
                    {
                        title: "{{__('messages.required_cookies')}}",
                        required: true,
                        content: "{!!__('messages.technical_cookies')!!}",
                    }
                ]
            }
        });
    }, 500);
</script>

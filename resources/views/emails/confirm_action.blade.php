<script type="application/ld+json">
    {
        "@context":"http://schema.org",
        "@type":"EmailMessage",
        "description":"Confirm your CFAC Invoice account",
        "action":
        {
            "@type":"ConfirmAction",
            "name":"Confirm account",
            "handler": {
                "@type": "HttpActionHandler",
                "url": "{{{ URL::to("user/confirm/{$user->confirmation_code}") }}}"
            },
            "publisher": {
                "@type": "Organization",
                "name": "CFAC Invoice",
                "url": "{{{ NINJA_WEB_URL }}}"
            }
        }
    }
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e(config('l5-swagger.documentations.'.$documentation.'.api.title')); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo e(l5_swagger_asset($documentation, 'swagger-ui.css')); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(l5_swagger_asset($documentation, 'favicon-32x32.png')); ?>" sizes="32x32"/>
    <link rel="icon" type="image/png" href="<?php echo e(l5_swagger_asset($documentation, 'favicon-16x16.png')); ?>" sizes="16x16"/>
    <style>
    html
    {
        box-sizing: border-box;
        overflow: -moz-scrollbars-vertical;
        overflow-y: scroll;
    }
    *,
    *:before,
    *:after
    {
        box-sizing: inherit;
    }

    body {
      margin:0;
      background: #fafafa;
    }
    </style>
</head>

<body>
<div id="swagger-ui"></div>

<script src="<?php echo e(l5_swagger_asset($documentation, 'swagger-ui-bundle.js')); ?>"></script>
<script src="<?php echo e(l5_swagger_asset($documentation, 'swagger-ui-standalone-preset.js')); ?>"></script>
<script>
    window.onload = function() {
        // Build a system
        const ui = SwaggerUIBundle({
            dom_id: '#swagger-ui',
            url: "<?php echo $urlToDocs; ?>",
            operationsSorter: <?php echo isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null'; ?>,
            configUrl: <?php echo isset($configUrl) ? '"' . $configUrl . '"' : 'null'; ?>,
            validatorUrl: <?php echo isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null'; ?>,
            oauth2RedirectUrl: "<?php echo e(route('l5-swagger.'.$documentation.'.oauth2_callback', [], $useAbsolutePath)); ?>",

            requestInterceptor: function(request) {
                request.headers['X-CSRF-TOKEN'] = '<?php echo e(csrf_token()); ?>';
                return request;
            },

            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],

            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],

            layout: "StandaloneLayout",
            docExpansion : "<?php echo config('l5-swagger.defaults.ui.display.doc_expansion', 'none'); ?>",
            deepLinking: true,
            filter: <?php echo config('l5-swagger.defaults.ui.display.filter') ? 'true' : 'false'; ?>,
            persistAuthorization: "<?php echo config('l5-swagger.defaults.ui.authorization.persist_authorization') ? 'true' : 'false'; ?>",

        })

        window.ui = ui

        <?php if(in_array('oauth2', array_column(config('l5-swagger.defaults.securityDefinitions.securitySchemes'), 'type'))): ?>
        ui.initOAuth({
            usePkceWithAuthorizationCodeGrant: "<?php echo (bool)config('l5-swagger.defaults.ui.authorization.oauth2.use_pkce_with_authorization_code_grant'); ?>"
        })
        <?php endif; ?>
    }
</script>
</body>
</html>
<?php /**PATH /var/www/html/vendor/darkaonline/l5-swagger/src/../resources/views/index.blade.php ENDPATH**/ ?>
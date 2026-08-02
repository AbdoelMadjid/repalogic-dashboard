<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>One Page Landing | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description"
        content="Inspinia is the #1 best-selling admin dashboard template on Wrapmarket. Perfect for building CRM, CMS, project management tools, and custom web apps with clean UI, responsive design, and powerful features." />
    <meta name="keywords"
        content="Inspinia, admin dashboard, Wrapmarket, Wrapbootstrap, HTML template, Bootstrap admin, CRM template, CMS template, responsive admin, web app UI, admin theme, best admin template" />
    <meta name="author" content="WebAppLayers" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

    @include('website.partials._css')
</head>

<body class="bg-body-secondary" data-bs-spy="scroll" data-bs-target="#navbar-example">
    <!-- Top Alert -->
    <!-- @include('website.partials._top-alert') -->

    <!-- Header START -->
    @include('website.partials._header')
    <!-- Header END -->

    <!-- ======================= HERO SECTION ======================= -->
    @include('website.section-hero')
    <!-- ======================= HERO SECTION END ======================= -->

    <!-- ======================= SERVICES SECTION ======================= -->
    @include('website.section-service')
    <!-- ======================= SERVICES SECTION END ======================= -->

    <!-- ======================= Features SECTION  ======================= -->
    @include('website.section-features')
    <!-- ======================= Features SECTION END ======================= -->

    <!-- ======================= PLANS SECTION ======================= -->
    @include('website.section-plans')
    <!-- ======================= PLANS SECTION END ======================= -->

    <!-- ======================= CTA SECTION ======================= -->
    @include('website.section-cta')
    <!-- ======================= CTA SECTION END ======================= -->

    <!-- ======================= REVIEWS SECTION ======================= -->
    @include('website.section-reviews')
    <!-- ======================= REVIEWS SECTION END ======================= -->

    <!-- ======================= BLOG SECTION ======================= -->
    @include('website.section-blog')
    <!-- ======================= BLOG SECTION END ======================= -->

    <!-- ======================= CONTACT SECTION ======================= -->
    @include('website.section-contact')
    <!-- ======================= CONTACT SECTION END ======================= -->

    <!-- ======================= FOOTER SECTION ======================= -->
    @include('website.partials._footer')
    <!-- ======================= FOOTER SECTION END ======================= -->


    @include('website.partials._js')
    @include('layouts.partials/back-to-top')
</body>

</html>

<!-- Required Meta Tags Always Come First -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="description" content="{{ $appProfil->meta_description ?? 'Education Portal & Management System' }}" />
<meta name="keywords" content="{{ $appProfil->meta_keywords ?? 'education, university, campus, school, portal' }}" />
<meta name="author" content="{{ $appProfil->meta_author ?? 'REPALOGIC' }}" />

<!-- App Favicon -->
@if ($appProfil && !empty($appProfil->favicon) && Storage::disk('public')->exists($appProfil->favicon))
    <link rel="shortcut icon" href="{{ asset('storage/' . $appProfil->favicon) }}" />
@else
    <link rel="shortcut icon" href="{{ asset('assets_default/images/favicon.ico') }}" />
@endif

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Barlow:300,400,400i,500,700%7CAlegreya:400" rel="stylesheet">

<!-- CSS Global Compulsory -->
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/bootstrap/bootstrap.min.css">

<!-- CSS Implementing Plugins -->
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/icon-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/icon-line-pro/style.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/icon-hs/style.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/icon-material/material-icons.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/animate.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/hs-megamenu/src/hs.megamenu.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/hamburgers/hamburgers.min.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/slick-carousel/slick/slick.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/fancybox/jquery.fancybox.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/dzsparallaxer/dzsparallaxer.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/dzsparallaxer/dzsscroller/scroller.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/dzsparallaxer/advancedscroller/plugin.css">
<link rel="stylesheet" href="{{ asset('asset_education/vendor') }}/hs-bg-video/hs-bg-video.css">

<!-- CSS Unify Theme -->
<link rel="stylesheet" href="{{ asset('asset_education/css') }}/styles.multipage-education.css">

<!-- CSS Customization -->
<link rel="stylesheet" href="{{ asset('asset_education/css') }}/custom.css">

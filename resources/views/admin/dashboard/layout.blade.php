<!DOCTYPE html>
<html>
<head>
    @include('admin.dashboard.component.head')
</head>
<body>
    <div id="wrapper">
       @include('admin.dashboard.component.slidebar')

        <div id="page-wrapper" class="gray-bg dashbard-1">
        @include('admin.dashboard.component.nav')
        @include($template)
        @include('admin.dashboard.component.footer')
        </div>
    </div>
    @include('admin.dashboard.component.script')
</body>
</html>     
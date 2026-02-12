@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin Panel</p>
    <h1>Content Management</h1>
    <p>Choose a section. Posting and list/manage pages are separated for clarity.</p>
</section>

<section class="admin-grid">
    <article class="card admin-card">
        <h2>Membership</h2>
        <p>Review applications and promote members.</p>
        <div class="inline-actions">
            <a class="btn btn-subtle" href="{{ route('admin.membership-applications.index') }}">Applications</a>
            <a class="btn btn-subtle" href="{{ route('admin.members.index') }}">Members</a>
        </div>
    </article>

    <article class="card admin-card">
        <h2>Notices</h2>
        <p>Create notices/events and manage the list.</p>
        <div class="inline-actions">
            <a class="btn btn-subtle" href="{{ route('admin.notices.create') }}">Post Notice</a>
            <a class="btn btn-subtle" href="{{ route('admin.notices.list') }}">Notice List</a>
        </div>
    </article>

    <article class="card admin-card">
        <h2>Slider</h2>
        <p>Post slider images and manage active items.</p>
        <div class="inline-actions">
            <a class="btn btn-subtle" href="{{ route('admin.media.slider.create') }}">Post Slider</a>
            <a class="btn btn-subtle" href="{{ route('admin.media.slider.list') }}">Slider List</a>
        </div>
    </article>

    <article class="card admin-card">
        <h2>Occasion Banners</h2>
        <p>Post celebration/mourning banners and manage list.</p>
        <div class="inline-actions">
            <a class="btn btn-subtle" href="{{ route('admin.media.banner.create') }}">Post Banner</a>
            <a class="btn btn-subtle" href="{{ route('admin.media.banner.list') }}">Banner List</a>
        </div>
    </article>
</section>
@endsection

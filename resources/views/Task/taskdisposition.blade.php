@extends('components.layout')

@section('content')

<style>
    /* Theme Color Customizations: Dark Green, Golden Yellow, and White */
    :root {
        --bs-dark-green: #0b3c29;
        --bs-medium-green: #134e38;
        --bs-accent-green: #1f7a55;
        --bs-golden-yellow: #d4af37;
        --bs-golden-yellow-light: #fef9e7;
    }

    body {
        background-color: #f8f9fa;
    }

    /* Modern Card Layouts */
    .card-activity {
        border: none;
        border-radius: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 0.5rem 1.25rem rgba(11, 60, 41, 0.04);
        background: #ffffff;
        overflow: hidden;
    }

    .card-activity:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.75rem 2rem rgba(11, 60, 41, 0.08);
        
    }

    /* Month Navigation Header Styling */
    .month-nav-container {
        background: #ffffff;
        border-radius: 50rem;
        padding: 0.5rem 1.5rem;
        box-shadow: 0 0.25rem 0.75rem rgba(11, 60, 41, 0.04);
        display: inline-flex;
        align-items: center;
    }

    .btn-month-nav {
        background-color: var(--bs-golden-yellow-light);
        color: var(--bs-dark-green);
        border: 1px solid rgba(212, 175, 55, 0.3);
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-month-nav:hover {
        background-color: var(--bs-golden-yellow);
        color: #ffffff;
    }

    /* Custom Buttons matching Dark Green & Golden Yellow */
    .btn-dark-green {
        background-color: var(--bs-dark-green);
        color: #ffffff;
        border: none;
        transition: background-color 0.2s ease;
    }

    .btn-dark-green:hover {
        background-color: var(--bs-medium-green);
        color: #ffffff;
    }

    .btn-golden {
        background-color: var(--bs-golden-yellow);
        color: #ffffff;
        border: none;
    }

    .btn-golden:hover {
        background-color: #b8972b;
        color: #ffffff;
    }

    /* Ribbons and Badges */
    .activity-badge-done {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid rgba(46, 125, 50, 0.2);
    }

    .activity-badge-today {
        background-color: var(--bs-golden-yellow-light);
        color: #8c7310;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }

    /* Modal styling polish */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15);
    }
     .pap-hero-card {
        background: #ffffff;
    color: var(--bs-dark-green);
    border: none;
    border-left: 10px solid var(--bs-dark-green);
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1.5rem rgba(10, 54, 34, 0.1);
    }
    .task-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.25rem rgba(10, 54, 34, 0.08);
        border-color: var(--bs-golden-yellow);
    }
</style>



sample



























    
@endsection
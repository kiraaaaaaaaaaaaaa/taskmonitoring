@extends('components.layout')

@section('content')

<style>
    :root {
        --green-dark: #0b3c29;
        --green: #145a3a;
        --green-soft: #eaf2ed;
        --gold: #d4af37;
        --gold-soft: #faf5df;
        --text-dark: #17221c;
        --text-muted: #7b857f;
        --border: #e7ebe8;
        --page-bg: #f5f7f6;
    }

    body {
        background: var(--page-bg);
    }

    /* ============================
       GRID
    ============================ */

    .pap-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    /* ============================
       SQUARE TILE
    ============================ */

    .pap-tile {
        position: relative;
        aspect-ratio: 1.3 / 1;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: .3s ease;
    }

    .pap-tile:hover {
        transform: translateY(-5px);
        border-color: rgba(212, 175, 55, .6);
        box-shadow: 0 15px 35px rgba(11, 60, 41, .10);
    }

    /* Gold corner decoration */
    .pap-tile::after {
        content: "";
        position: absolute;
        width: 75px;
        height: 75px;
        right: -35px;
        bottom: -35px;
        border-radius: 50%;
        background: var(--gold-soft);
        transition: .3s ease;
    }

    .pap-tile:hover::after {
        transform: scale(1.8);
    }

    /* ============================
       TOP
    ============================ */

    .pap-tile-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .pap-number {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        color: var(--text-muted);
    }

    .pap-menu {
        width: 34px;
        height: 34px;
        border: 1px solid var(--border);
        background: #fff;
        border-radius: 8px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
    }

    .pap-menu:hover {
        background: var(--green-dark);
        color: #fff;
        border-color: var(--green-dark);
    }

    /* ============================
       ICON
    ============================ */

    .pap-icon-wrapper {
    width: 100%;
    height: clamp(80px, 10vw, 130px);

    display: flex;
    align-items: center;
    justify-content: center;
}

.pap-icon-wrapper i {
    font-size: clamp(45px, 5vw, 80px);
    line-height: 1;
    color: #d4af37;
}

    

    /* ============================
       CONTENT
    ============================ */

    .pap-content {
        margin-top: auto;
        position: relative;
        z-index: 2;
    }

    .pap-category {
        font-size: clamp(9px, 2.5cqw, 12px);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: clamp(0.8px, 0.3cqw, 1.2px);
    color: var(--gold);
    margin-bottom: 7px;
    }

    .pap-title {
        font-size: 17px;
        font-weight: 700;
        line-height: 1.4;
        color: var(--text-dark);
        margin: 0;
    }

    /* ============================
       FOOTER
    ============================ */

    .pap-footer {
        margin-top: 18px;
        padding-top: 13px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        z-index: 3;
    }

    .pap-status {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--green);
    }

    .pap-open {
        width: 31px;
        height: 31px;
        border-radius: 50%;
        background: var(--green-dark);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: .25s;
    }

    .pap-open:hover {
        background: var(--gold);
        color: var(--green-dark);
        transform: translateX(3px);
    }

    /* ============================
       DROPDOWN
    ============================ */

    .pap-dropdown {
        border: none;
        padding: 6px;
        border-radius: 10px;
        box-shadow: 0 12px 35px rgba(0,0,0,.12);
    }

    .pap-dropdown .dropdown-item {
        border-radius: 7px;
        padding: 9px 12px;
        font-size: 13px;
    }

    .pap-dropdown .dropdown-item:hover {
        background: var(--green-soft);
    }

    /* ============================
       RESPONSIVE
    ============================ */

    @media (max-width: 1200px) {
        .pap-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .pap-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .pap-grid {
            grid-template-columns: 1fr;
        }

        .pap-tile {
            aspect-ratio: auto;
            min-height: 280px;
        }
    }
    /* ============================
   ACTIVITY TABS
============================ */

.activity-tabs-wrapper {
    margin-bottom: 28px;
}

.activity-tabs {
    display: flex;
    align-items: center;
    gap: 4px;
    width: fit-content;
    padding: 5px;
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(11, 60, 41, 0.04);
}

.activity-tab {
    border: none;
    background: transparent;
    color: var(--text-muted);
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 7px;
    transition: all 0.25s ease;
}

.activity-tab i {
    font-size: 16px;
}

.activity-tab:hover {
    color: var(--green-dark);
    background: var(--green-soft);
}

.activity-tab.active {
    background: var(--green-dark);
    color: #ffffff;
    box-shadow: 0 3px 8px rgba(11, 60, 41, 0.15);
}

.activity-tab.active i {
    color: var(--gold);
}


/* TAB CONTENT */

.activity-pane {
    animation: activityFade .25s ease;
}

@keyframes activityFade {
    from {
        opacity: 0;
        transform: translateY(5px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* MOBILE */

@media (max-width: 576px) {

    .activity-tabs-wrapper {
        overflow-x: auto;
        padding-bottom: 4px;
    }

    .activity-tabs {
        width: max-content;
    }

    .activity-tab {
        padding: 9px 13px;
        font-size: 12px;
    }
}
</style>



<div class="container-fluid">

    <!-- PAGE HEADER -->
   <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <!-- Title -->
    <div>
        <h3
            class="fw-bold mb-2"
            style="color: var(--green-dark);">
            Program, Activities, and Projects (PAP) Disposition
        </h3>

        <div
            class="d-inline-flex px-3 py-2 rounded-pill"
            style="
                background: var(--green-soft);
                color: var(--green-dark);
                font-size: 12px;
                font-weight: 700;
            ">
            {{ count($newtask) }} Activities
        </div>
    </div>

    <!-- Right Side Actions -->
    <div class="d-flex align-items-center gap-2 ms-auto">

        <!-- Add PAP Button -->
        <button
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#addPapModal"
            class="btn btn-label waves-effect waves-light rounded-pill shadow-sm" style="background-color: var(--green-dark); color: #fff;">

            <i class="ri-add-fill align-middle rounded-pill fs-16 me-2"></i>
            Add PAP

        </button>

    </div>

</div>

      
   


    <!-- GRID -->
    <div class="pap-grid">
    

        @foreach ($newtask as $index => $task)

            <div class="pap-tile">

                <!-- TOP -->
                <div class="pap-tile-top">

                    <span class="pap-number">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>


                    <div class="dropdown">

                        <button
                            type="button"
                            class="pap-menu"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            <i class="ri-more-2-fill"></i>

                        </button>


                        <ul
                            class="dropdown-menu dropdown-menu-end pap-dropdown">

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="/Task/newtask/{{ $task->id }}">

                                    <i class="ri-eye-line me-2 text-primary"></i>

                                    View Details

                                </a>

                                
                                                        <div class="dropdown-divider"></div>
                                                        <form action="/papmangement/pap/{{$task->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this PAP?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                                <i class="ri-delete-bin-line me-2"></i> Delete PAP
                                                            </button>
                                                        </form>

                            </li>

                        </ul>

                    </div>

                </div>


                <!-- ICON -->
                <div class="pap-icon-wrapper">

                    <i class="ri-folder-chart-line"></i>

                </div>


                <!-- CONTENT -->
                <div class="pap-content">

                    <div class="pap-category">
                        PAP Activity
                    </div>

                    <h5
                        class="pap-title"
                        title="{{ $task->pap }}">

                        {{ $task->pap }}

                    </h5>

                </div>


               
            </div>

        @endforeach

    </div>

</div>

<div class="modal fade" id="addPapModal" tabindex="-1" aria-labelledby="addPapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-custom p-4">
                <h5 class="modal-title fw-bold" id="addPapModalLabel">Create New PAP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('createPAP') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="PAPname" class="form-label fw-semibold">PAP Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="PAPname" name="PAPname" placeholder="Enter PAP Name" required>
                    </div>
                   
                    <div class="mb-3" style="display: none;">
                        <select class="form-select" id="sectorselect" name="sectorselect">
                            <option value="" disabled selected>-- Select Sector --</option>
                            <option value="{{ Auth::user()->sectorID ?? '' }}"></option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="divisionSelect" class="form-label fw-semibold">Assign Division <span class="text-danger">*</span></label>
                            <select class="form-select shadow-none" id="divisionSelect" name="divisionSelect" required>
                                <option value="" disabled selected>-- Select Division --</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="funds" class="form-label fw-semibold">Fund Source <span class="text-danger">*</span></label>
                            <select class="form-select shadow-none" id="funds" name="funds" required>
                             <option value="" disabled selected>-- Select Source of Fund --</option>
                                @foreach($fund as $funds)
                                <option value="{{ $funds->id }}">{{ $funds->fundName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="focalSelect" class="form-label fw-semibold">Assign Focal <span class="text-danger">*</span></label>
                            <select class="form-select shadow-none" id="focalSelect" name="focalSelect" required>
                                <option value="" disabled selected>-- Select Focal --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="oosSelect" class="form-label fw-semibold">Output/Outcome Supported <span class="text-danger">*</span></label>
                            <select class="form-select shadow-none" id="oosSelect" name="oosSelect" required>
                                <option value="" disabled selected>-- Select Output/Outcome --</option>
                                @foreach($oos as $user)
                                <option value="{{ $user->oosID }}">{{ $user->oosName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-theme-accent rounded-pill px-4" name="action" value="pap">Save Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>





















<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputsector = document.getElementById('sectorselect');
        const inputdivision = document.getElementById('divisionSelect');
        const sector = {!! json_encode($sector) !!};
        const division = {!! json_encode($division) !!};

        inputsector.addEventListener('change', function () {
            const programID = this.value;
            inputdivision.innerHTML = '<option value="">--Select Division--</option>';

            division.forEach(div => {
                if(div.sectorID == programID){
                    let option = document.createElement('option');
                    option.value = div.id;
                    option.textContent = div.division_name + " (" + div.division_short_name + ")";
                    inputdivision.appendChild(option);
                }
            });
        });

        if (inputsector && !inputsector.value) {
            inputsector.selectedIndex = 1; 
        }

        if(inputsector) {
            inputsector.dispatchEvent(new Event('change'));
        }

        
    });
    document.addEventListener("DOMContentLoaded", function () {

    // Hide all task rows when page loads
    document.querySelectorAll(".task-row").forEach(function (task) {
        task.classList.add("d-none");
    });

    // Set all arrows to right arrow initially
    document.querySelectorAll(".toggle-icon").forEach(function (icon) {
        icon.classList.remove("ri-arrow-down-s-line");
        icon.classList.add("ri-arrow-right-s-line");

        icon.addEventListener("click", function () {

            const papId = this.dataset.pap;
            const tasks = document.querySelectorAll(".task-group-" + papId);

            tasks.forEach(function (task) {
                task.classList.toggle("d-none");
            });

            if (this.classList.contains("ri-arrow-down-s-line")) {
                this.classList.remove("ri-arrow-down-s-line");
                this.classList.add("ri-arrow-right-s-line");
            } else {
                this.classList.remove("ri-arrow-right-s-line");
                this.classList.add("ri-arrow-down-s-line");
            }

        });
    });

});


</script>





    
@endsection
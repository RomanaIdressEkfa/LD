@extends('layouts.admin')

@section('content')
<div class="row">
    
    <!-- LEFT SIDE: DYNAMIC FORM (CREATE OR EDIT) -->
    <div class="col-lg-4 mb-4">
        <div class="card-custom h-100 {{ isset($targetDebate) ? 'border-warning' : '' }}">
            
            <!-- FIXED: Changed background color logic here -->
            <div class="p-4 border-bottom rounded-top {{ isset($targetDebate) ? 'bg-warning bg-opacity-10' : 'bg-white' }}">
                <h5 class="fw-bold m-0 {{ isset($targetDebate) ? 'text-dark' : 'text-primary' }}">
                    @if(isset($targetDebate))
                        <i class="fa-solid fa-pen-to-square me-2"></i>Edit Debate
                    @else
                        <i class="fa-solid fa-plus-circle me-2"></i>Create New Debate
                    @endif
                </h5>
            </div>

            <div class="p-4">
                <form action="{{ isset($targetDebate) ? route('admin.debates.update', $targetDebate->id) : route('admin.debates.store') }}" method="POST">
                    @csrf
                    @if(isset($targetDebate))
                        @method('PUT')
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Debate Title</label>
                        <input type="text" name="title" 
                               class="form-control bg-light border-0 py-3" 
                               placeholder="e.g. Is AI safe?" 
                               value="{{ $targetDebate->title ?? '' }}" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Description</label>
                        <textarea name="description" 
                                  class="form-control bg-light border-0" 
                                  rows="6" 
                                  placeholder="Write the debate context here..." 
                                  required>{{ $targetDebate->description ?? '' }}</textarea>
                    </div>

                    <!-- FIXED: Participant Limit Section with Pre-fill Logic -->
                    @php
                        // Check if we are editing and if a limit exists
                        $isCustom = isset($targetDebate) && !is_null($targetDebate->max_participants);
                    @endphp

                    <div class="row mb-3 ">
                        <label class="form-label fw-bold small text-uppercase text-muted">Participant Limit</label>
                        <div class="col-md-6">
                            <select name="limit_option" class="form-select bg-light border-0" id="limitSelect" onchange="toggleLimitInput()">
                                <option value="unlimited" {{ (!$isCustom) ? 'selected' : '' }}>Unlimited</option>
                                <option value="custom" {{ ($isCustom) ? 'selected' : '' }}>Set Limit</option>
                            </select>
                        </div>
                        
                        <!-- Show input if $isCustom is true -->
                        <div class="col-md-6" id="limitInputDiv" style="{{ $isCustom ? 'display:block' : 'display:none' }};">
                            <input type="number" name="max_participants" 
                                   class="form-control bg-light border-0" 
                                   placeholder="e.g. 2"
                                   value="{{ $targetDebate->max_participants ?? '' }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                        <select name="status" class="form-select bg-light border-0 py-2">
                            <option value="active" {{ (isset($targetDebate) && $targetDebate->status == 'active') ? 'selected' : '' }}>Active (Visible)</option>
                            <option value="closed" {{ (isset($targetDebate) && $targetDebate->status == 'closed') ? 'selected' : '' }}>Closed (Hidden)</option>
                        </select>
                    </div>

                    <button class="btn w-100 py-3 fw-bold shadow-sm {{ isset($targetDebate) ? 'btn-warning text-dark' : 'btn-primary' }}">
                        {{ isset($targetDebate) ? 'Update Debate' : 'Launch Debate' }}
                    </button>

                    @if(isset($targetDebate))
                        <a href="{{ route('admin.debates.index') }}" class="btn btn-light w-100 mt-2 text-muted">Cancel Edit</a>
                    @endif

                </form>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: HISTORY LIST (Unchanged, kept for context) -->
    <div class="col-lg-8">
        <div class="card-custom h-100">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0 text-dark">
                    <i class="fa-solid fa-list me-2"></i>Debate History
                </h5>
                <span class="badge bg-light text-dark border">{{ $debates->count() }} Total</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase small text-muted">
                            <th class="ps-4">Title</th>
                            <th>Status</th>
                            <th>Limit</th> <!-- Added Limit Column -->
                            <th>Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($debates as $debate)
                        <tr class="{{ (isset($targetDebate) && $targetDebate->id == $debate->id) ? 'table-warning' : '' }}">
                            <td class="ps-4">
                                <span class="fw-bold text-dark d-block text-truncate" style="max-width: 200px;">
                                    {{ $debate->title }}
                                </span>
                            </td>
                            <td>
                                @if($debate->status == 'active')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Active</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">Closed</span>
                                @endif
                            </td>
                            <td>
                                <!-- Show Limit Info -->
                                @if($debate->max_participants)
                                    <span class="badge bg-primary bg-opacity-10 text-primary">Max: {{ $debate->max_participants }}</span>
                                @else
                                    <span class="badge bg-light text-muted border">Unlimited</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                {{ $debate->created_at->format('d M Y') }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.debates.edit', $debate->id) }}" class="btn btn-sm btn-light border text-primary me-1">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.debates.destroy', $debate->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this debate?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light border text-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    function toggleLimitInput() {
        var select = document.getElementById('limitSelect');
        var inputDiv = document.getElementById('limitInputDiv');
        if(select.value === 'custom') {
            inputDiv.style.display = 'block';
        } else {
            inputDiv.style.display = 'none';
        }
    }
</script>
@endsection
<div>
    <!-- Patient Modal -->
    @if($isPatientModalOpen)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Register Patient</h5>
                    <button type="button" class="btn-close" wire:click="$set('isPatientModalOpen', false)"></button>
                </div>
                <div class="modal-body">
                    @if($modalError) <div class="alert alert-danger">{{ $modalError }}</div> @endif
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model="new_name">
                        @error('new_name') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model="new_phone">
                            @error('new_phone') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Age <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" wire:model="new_age">
                            @error('new_age') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select class="form-select" wire:model="new_gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('isPatientModalOpen', false)">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="quickAddPatient">Register & Select</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Doctor Modal -->
    @if($isDoctorModalOpen)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Add Doctor</h5>
                    <button type="button" class="btn-close" wire:click="$set('isDoctorModalOpen', false)"></button>
                </div>
                <div class="modal-body">
                    @if($modalError) <div class="alert alert-danger">{{ $modalError }}</div> @endif
                    <div class="mb-3">
                        <label class="form-label">Doctor Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model="new_doc_name" placeholder="Dr. Name">
                        @error('new_doc_name') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" wire:model="new_doc_phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Commission (%)</label>
                        <input type="number" class="form-control" wire:model="new_doc_commission">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('isDoctorModalOpen', false)">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="quickAddDoctor">Add & Select</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Agent Modal -->
    @if($isAgentModalOpen)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Add Agent</h5>
                    <button type="button" class="btn-close" wire:click="$set('isAgentModalOpen', false)"></button>
                </div>
                <div class="modal-body">
                    @if($modalError) <div class="alert alert-danger">{{ $modalError }}</div> @endif
                    <div class="mb-3">
                        <label class="form-label">Agent Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model="new_agent_name">
                        @error('new_agent_name') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Agency Name</label>
                        <input type="text" class="form-control" wire:model="new_agent_agency">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" wire:model="new_agent_phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Commission (%)</label>
                        <input type="number" class="form-control" wire:model="new_agent_commission">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('isAgentModalOpen', false)">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="quickAddAgent">Add & Select</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Mode Modal -->
    @if($isPaymentModeModalOpen)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment Mode</h5>
                    <button type="button" class="btn-close" wire:click="$set('isPaymentModeModalOpen', false)"></button>
                </div>
                <div class="modal-body">
                    @if($modalError) <div class="alert alert-danger">{{ $modalError }}</div> @endif
                    <div class="mb-3">
                        <label class="form-label">Mode Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model="new_payment_mode_name" placeholder="UPI, PhonePe, etc.">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('isPaymentModeModalOpen', false)">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="quickAddPaymentMode">Add Mode</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

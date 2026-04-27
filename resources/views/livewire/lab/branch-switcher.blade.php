<div class="nxl-h-item dropdown">
    @if(auth()->user()->hasRole('lab_admin') || auth()->user()->hasRole('super_admin'))
        <a href="javascript:void(0);" 
           class="nxl-head-link me-3 border-0 rounded-pill px-3 py-2 d-flex align-items-center gap-2 bg-white bg-opacity-10 shadow-none hover-bg-opacity-20 transition-all" 
           data-bs-toggle="dropdown" 
           role="button" 
           data-bs-auto-close="outside"
           style="border: 1px solid rgba(255,255,255,0.1) !important;">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 24px; height: 24px;">
                <i class="feather-git-merge fs-12"></i>
            </div>
            <span class="fs-12 fw-bold text-white text-truncate d-none d-md-inline-block" style="max-width: 150px; letter-spacing: 0.3px;">
                @if($activeBranchId === 'all' || !$activeBranchId)
                    All Branches
                @else
                    {{ collect($branches)->firstWhere('id', $activeBranchId)['name'] ?? \App\Models\Branch::find($activeBranchId)?->name ?? 'Select Branch' }}
                @endif
            </span>
            <i class="feather-chevron-down fs-10 text-white opacity-50 ms-1"></i>
        </a>
        
        <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown shadow-lg border-0 rounded-4 p-0 overflow-hidden" 
             style="min-width: 340px; margin-top: 15px !important; background: rgba(15, 23, 42, 0.95) !important; backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1) !important; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;">
            
            <div class="dropdown-header p-4 pb-3 border-bottom border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white fw-bold mb-0 fs-13" style="letter-spacing: 0.5px;">Network Infrastructure</h6>
                        <span class="text-white text-opacity-40 fs-10 text-uppercase fw-bold ls-2">Select Branch Context</span>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3">
                        <i class="feather-layers fs-14"></i>
                    </div>
                </div>
            </div>
            
            <div class="p-3 max-h-300 overflow-y-auto custom-scrollbar">
                {{-- Standard View --}}
                <a href="javascript:void(0);" 
                   wire:click="switchBranch('all')" 
                   class="branch-card transition-all {{ ($activeBranchId === 'all' || !$activeBranchId) ? 'active' : '' }}">
                    <div class="branch-icon-wrap all-branches">
                        <i class="feather-globe"></i>
                    </div>
                    <div class="branch-info">
                        <span class="branch-name">Global Overview</span>
                        <span class="branch-meta">Consolidated Data (All Branches)</span>
                    </div>
                    <div class="active-indicator"></div>
                </a>
                
                <div class="my-3 border-top border-white border-opacity-5"></div>

                @forelse($branches as $branch)
                    <a href="javascript:void(0);" 
                       wire:click="switchBranch({{ $branch->id }})" 
                       class="branch-card transition-all {{ $activeBranchId == $branch->id ? 'active' : '' }} mb-2">
                        <div class="branch-icon-wrap {{ $branch->type === 'main_lab' ? 'main-lab' : 'satellite' }}">
                            <i class="{{ $branch->type === 'main_lab' ? 'feather-activity' : 'feather-map-pin' }}"></i>
                        </div>
                        <div class="branch-info">
                            <div class="d-flex align-items-center gap-2">
                                <span class="branch-name">{{ $branch->name }}</span>
                                <span class="status-tag {{ $branch->type === 'main_lab' ? 'bg-danger' : 'bg-info' }}">
                                    {{ $branch->type === 'main_lab' ? 'PRIMARY' : 'SATELLITE' }}
                                </span>
                            </div>
                            <span class="branch-meta">{{ $branch->type === 'main_lab' ? 'Main Processing Laboratory' : 'Clinical Collection Center' }}</span>
                        </div>
                        <div class="active-indicator"></div>
                    </a>
                @empty
                    <div class="p-5 text-center">
                        <div class="bg-white bg-opacity-5 w-40 h-40 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                            <i class="feather-cloud-off text-white text-opacity-20 fs-4"></i>
                        </div>
                        <span class="text-white text-opacity-30 fs-12 fw-medium">Infrastructure Offline</span>
                    </div>
                @endforelse
            </div>
            
            <div class="p-3 bg-white bg-opacity-5 border-top border-white border-opacity-10">
                <a href="{{ route('lab.branches') }}" wire:navigate class="manage-btn">
                    <span>Manage Infrastructure Network</span>
                    <i class="feather-settings"></i>
                </a>
            </div>
        </div>
    @endif
    
    <style>
        .max-h-300 { max-height: 300px; }
        .ls-2 { letter-spacing: 0.8px; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        
        /* Premium Branch Cards */
        .branch-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 15px;
            border-radius: 12px;
            text-decoration: none !important;
            border: 1px solid transparent;
            position: relative;
            background: rgba(255, 255, 255, 0.02);
        }
        
        .branch-card:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateY(-2px);
            border-color: rgba(255,255,255,0.1);
        }
        
        .branch-card.active {
            background: linear-gradient(90deg, rgba(59, 113, 202, 0.15) 0%, rgba(59, 113, 202, 0.05) 100%);
            border-color: rgba(59, 113, 202, 0.3);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        /* Icon Wrap with Gradients */
        .branch-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        
        .all-branches { background: linear-gradient(135deg, #3b71ca 0%, #1e3a8a 100%); color: white; }
        .main-lab { background: linear-gradient(135deg, #ef4444 0%, #991b1b 100%); color: white; }
        .satellite { background: linear-gradient(135deg, #0ea5e9 0%, #075985 100%); color: white; }
        
        /* Info Styling */
        .branch-info { display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; }
        .branch-name { color: #ffffff; font-weight: 700; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .branch-meta { color: rgba(255,255,255,0.4); font-size: 10px; font-weight: 500; }
        
        /* Status Tags */
        .status-tag {
            font-size: 8px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: white;
            background-opacity: 0.8;
        }
        
        /* Active Indicator Glow */
        .active-indicator {
            position: absolute;
            right: 15px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: transparent;
            transition: all 0.3s ease;
        }
        
        .branch-card.active .active-indicator {
            background: #3b71ca;
            box-shadow: 0 0 10px #3b71ca, 0 0 20px #3b71ca;
        }
        
        /* Manage Button */
        .manage-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #3b71ca;
            color: white !important;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none !important;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .manage-btn:hover {
            background: #2a5298;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 113, 202, 0.4);
        }
    </style>
</div>

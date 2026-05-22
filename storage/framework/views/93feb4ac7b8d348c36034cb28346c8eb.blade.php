
                                <div style="
                                    background: #ffffff;
                                    margin: -24px -24px 24px -24px;
                                    padding: 40px;
                                    border-radius: 24px 24px 0 0;
                                    display: flex;
                                    align-items: center;
                                    gap: 32px;
                                    position: relative;
                                    overflow: hidden;
                                    width: calc(100% + 48px);
                                    border-bottom: 1px solid #e4e4e7;
                                ">
                                    {{-- Accent glow --}}
                                    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(197, 160, 89, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                                    
                                    <div style="position: relative; z-index: 10;">
                                        @if($record->getFirstMediaUrl("avatar"))
                                            <img src="{{ $record->getFirstMediaUrl("avatar") }}" style="width: 100px; height: 100px; border-radius: 24px; object-fit: cover; border: 1px solid #e4e4e7; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                                        @else
                                            <div style="width: 100px; height: 100px; border-radius: 24px; background: rgba(197, 160, 89, 0.1); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(197, 160, 89, 0.2); box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                                                <span style="font-size: 2.5rem; font-weight: 800; color: var(--bt-gold);">{{ substr($record->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div style="position: relative; z-index: 10;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <h1 style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.5px;">{{ $record->name }}</h1>
                                            <span style="padding: 4px 12px; border-radius: 99px; background: @if($record->is_active) rgba(16, 185, 129, 0.1) @else rgba(244, 63, 94, 0.1) @endif; color: @if($record->is_active) #059669 @else #e11d48 @endif; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                                                {{ $record->is_active ? "Active" : "Inactive" }}
                                            </span>
                                        </div>
                                        <p style="color: #64748b; margin: 4px 0 0; font-size: 1rem; font-weight: 500;">{{ $record->email }}</p>
                                        <div style="display: flex; gap: 8px; margin-top: 12px;">
                                            @foreach($record->roles as $role)
                                                <span style="padding: 4px 12px; border-radius: 6px; background: #f8fafc; color: #475569; font-size: 0.75rem; font-weight: 600; border: 1px solid #e2e8f0;">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            
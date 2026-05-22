
                                                <div style="display: flex; flex-direction: column; gap: 12px;">
                                                    @forelse(\Spatie\Activitylog\Models\Activity::where("causer_id", $record->id)->latest()->take(15)->get() as $log)
                                                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border-radius: 12px; border: 1px solid #f3f4f6; background-color: #f9fafb;">
                                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                                <div style="width: 32px; height: 32px; border-radius: 10px; background-color: @if(str_contains($log->description, "created")) #ecfdf5 @elseif(str_contains($log->description, "deleted")) #fef2f2 @else #fff7ed @endif; display: flex; align-items: center; justify-content: center;">
                                                                    @php
                                                                        $icon = match(class_basename($log->subject_type)) {
                                                                            "Project" => "🏗️", "Inquiry" => "📧", "News" => "📰", "Award" => "🏆", "User" => "👤", default => "⚙️",
                                                                        };
                                                                    @endphp
                                                                    <span style="font-size: 16px;">{{ $icon }}</span>
                                                                </div>
                                                                <div>
                                                                    <div style="font-size: 14px; font-weight: 700; color: #111827; text-transform: capitalize;">{{ $log->description }}</div>
                                                                    <div style="font-size: 12px; color: #6b7280;">{{ class_basename($log->subject_type) }}</div>
                                                                </div>
                                                            </div>
                                                            <div style="font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em;">{{ $log->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    @empty
                                                        <div style="text-center; padding: 32px 0; color: #9ca3af; font-style: italic; font-size: 14px;">No recent activity found for this administrator.</div>
                                                    @endforelse
                                                </div>
                                            
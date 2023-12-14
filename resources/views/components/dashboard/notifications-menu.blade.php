 <!-- Notifications Dropdown Menu -->
 <li class="nav-item dropdown">
     <a class="nav-link" data-toggle="dropdown" href="#">
         <i class="far fa-bell"></i>
         @if ($unread_count)
             <span class="badge badge-warning navbar-badge">{{ $unread_count }}</span>
         @endif
     </a>
     <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <span class="dropdown-header">{{ $unread_count }} Notifications</span>
         <div class="dropdown-divider"></div>
         @foreach ($notifications as $notification)
             <a href="{{ $notification->data['url'] }}?noti_id={{ $notification->id }}"
                 class="dropdown-item @if ($notification->unread()) {{ 'text-bold' }} @endif">
                 <p><i class="{{ $notification->data['icon'] }}"></i>
                     <span style="width: auto">{{ $notification->data['body'] }}</span>
                 </p>
                 <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
             </a>
             <div class="dropdown-divider"></div>
         @endforeach
         <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
     </div>
 </li>

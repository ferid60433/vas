<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="{{ url('/') }}">
          <i class="fa fa-tachometer"></i>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('compose') }}">
          <i class="fa fa-paper-plane"></i>
          Compose
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('inbox') }}">
          <i class="fa fa-inbox"></i>
          Inbox
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('outbox') }}">
          <i class="fa fa-envelope"></i>
          Outbox
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('services') }}">
          <i class="fa fa-tags"></i>
          Services
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('subscribers') }}">
          <i class="fa fa-tags"></i>
          Subscribers
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('settings') }}">
          <i class="fa fa-cogs"></i>
          Settings
        </a>
      </li>
    </ul>
  </div>
</nav>

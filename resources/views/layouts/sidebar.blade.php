<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url(auth()->user()->photo ?? '') }}" class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            
            @if (auth()->user()->level == 1)
            <li class="header">MAIN MENU</li>
            
            <li>
                <a href="{{ route('category.index') }}">
                    <i class="fa fa-cube"></i> <span>Category</span>
                </a>
            </li>

            <li>
                <a href="{{ route('product.index') }}">
                    <i class="fa fa-cubes"></i> <span>Product</span>
                </a>
            </li>

            <li>
                <a href="{{ route('member.index') }}">
                    <i class="fa fa-id-card"></i> <span>Member</span>
                </a>
            </li>

            <li>
                <a href="{{ route('supplier.index') }}">
                    <i class="fa fa-shopping-cart"></i> <span>Supplier</span>
                </a>
            </li>

            <li class="header">TRANSACTION</li>

            <li>
                <a href="{{ route('spending.index') }}">
                    <i class="fa fa-gg-circle"></i> <span>Spending</span>
                </a>
            </li>

            <li>
                <a href="{{ route('purchase.index') }}">
                    <i class="fa fa-mail-reply"></i> <span>Purchasing</span>
                </a>
            </li>

            <li>
                <a href="{{ route('sell.index') }}">
                    <i class="fa fa-mail-forward"></i> <span>Selling</span>
                </a>
            </li>

            <li>
                <a href="{{ route('transaction.index') }}">
                    <i class="fa fa-exchange"></i> <span>Active Transaction</span>
                </a>
            </li>

            <li>
                <a href="{{ route('transaction.new') }}">
                    <i class="fa fa-exchange"></i> <span>New Transaction</span>
                </a>
            </li>

            <li class="header">REPORT</li>

            <li>
                <a href="{{ route('report.index') }}">
                    <i class="fa fa-database"></i> <span>Reports</span>
                </a>
            </li>

            <li class="header">SETTING</li>

            <li>
                <a href="{{ route('user.index') }}">
                    <i class="fa fa-users"></i> <span>Users</span>
                </a>
            </li>

            <li>
                <a href="{{ route('setting.index') }}">
                    <i class="fa fa-gears"></i> <span>Settings</span>
                </a>
            </li>
            @else
            <li>
                <a href="{{ route('transaction.index') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Active Transaction</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaction.new') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>New Transaction</span>
                </a>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
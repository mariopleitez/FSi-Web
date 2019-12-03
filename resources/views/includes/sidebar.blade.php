<?php  $alias = request()->route()->getAction("as"); ?>
{{-- {{  dd($data) }}
{{ dd(Request::segments()) }} --}}
 <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">PERSONAL</li>
                        <li> 
                            <a class="has-arrow waves-effect waves-dark" href="{{ route('admin.home') }}" aria-expanded="false">
                                <i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span>
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Mantenimientos</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{ route('posts.index') }}">Posts</a></li>
                                <li><a href="{{ route('post-types.index') }}">Tipo de proyectos</a></li>
                                <li><a href="{{ route('authors.index') }}">Redactores</a></li>
                                <hr>
                                <li><a href="{{ route('users.index') }}">Usuarios</a></li>
                                <li><a href="{{ route('subscriptions.index') }}">Subscripciones</a></li>
                                <li><a href="{{ route('transactions.index') }}">Transacciones</a></li>
                                <li><a href="{{ route('plans.index') }}">Planes</a></li>
                                <li><a href="{{ route('commissions.index') }}">Comisiones</a></li>
                                <li><a href="{{ route('mentions.index') }}">Menciones</a></li>
                                <hr>
                                <li><a href="{{ route('countries.index') }}">Paises</a></li>
                                <li><a href="{{ route('states.index') }}">Departamentos</a></li>
                                <li><a href="{{ route('cities.index') }}">Ciudades</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>

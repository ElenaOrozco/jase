<!-- sidebar menu: : style can be found in sidebar.less -->
 <ul class="sidebar-menu">
    <li class="header">MENU PRINCIPAL</li>
    <li>
      <a href="<?php echo site_url(); ?>">
        <i class="fa fa-dashboard"></i> <span>Principal</span>
      </a>
      
    </li>
    <?php if (is_admin()): ?>

      
      <li class="treeview">
        <a href="#">
          <i class="fa fa-folder"></i> <span>Catálogos</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url("control_usuarios/"); ?>"><i class="fa fa-circle-o text-red"></i> Usuarios</a></li>
          <li><a href="<?php echo site_url("tipos_usuarios/"); ?>"><i class="fa fa-circle-o text-red"></i> Tipos Usuarios</a></li>
          <li><a href="<?php echo site_url("modalidad/"); ?>"><i class="fa fa-circle-o text-red"></i> Modalidades</a></li>
          
          <li><a href="<?php echo site_url("documentos/"); ?>"><i class="fa fa-circle-o text-red"></i> Documentos</a></li>
          <li><a href="<?php echo site_url("poa/partidas"); ?>"><i class="fa fa-circle-o text-red"></i> Fondos</a></li>
        </ul>
      </li>
    <?php endif ; ?>
    <?php if (!is_contractor()): ?>
     
	    <li>
	      <a href="<?php echo site_url("contratistas/"); ?>">
	        <i class="fa fa-id-card mr-1"></i> <span> Padrón de Contratistas</span>
	      </a>
	      
	    </li>
	    <li>
	      <a href="<?php echo site_url("poa/"); ?>">
	        <i class="fa fa-usd"></i> <span>Catálogo POA</span> 
	      </a>
	      
	    </li>

	    
      <li class="treeview">
        <a href="#">
          <i class="fa fa-calendar" aria-hidden="true"></i> <span>Programación</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="<?php echo site_url("obras/nueva_obra"); ?>"><i class="fa fa-circle-o text-red"></i> Nueva Obra</a>
          </li>
          <li>
            <a href="<?php echo site_url("obras/obras_programacion"); ?>"><i class="fa fa-circle-o text-red"></i> Listado de Obras</a>
          </li>
          <!--
          <li>
            <a href="<?php echo site_url("obras/listar/3"); ?>"><i class="fa fa-circle-o text-red"></i> Obras Recepción</a>
          </li>
          <li>
            <a href="<?php echo site_url("obras/listar/1"); ?>"><i class="fa fa-circle-o text-red"></i> Obras por Contrato</a>
          </li>
          <li>
            <a href="<?php echo site_url("obras/listar/2"); ?>"><i class="fa fa-circle-o text-red"></i> Obras OAD</a>
          </li>
          -->
        </ul>
      </li>
      <li>
        <a href="<?php echo site_url("presupuesto/"); ?>">
          <i class="fa fa-usd"></i> <span>Presupuestación</span>
        </a>
        
      </li>

      <li>
        <a href="<?php echo site_url("presupuesto/"); ?>">
          <i class="fa fa-briefcase" aria-hidden="true"></i> <span>Ejecución de Obras</span>
        </a>
        
      </li>
      <li class="header">ARCHIVO</li>
      <li>
        <a href="<?php echo site_url("obras/listar/3"); ?>">
          <i class="fa fa-table"></i> <span>Archivo de Obra</span>
        </a>
        
      </li>
      
      
      
    
	<?php endif; ?>
  <?php if (is_contractor()): ?>
    
    <li>
      <a href="<?php echo base_url() ."estimaciones/" ?>">
        <i class="fa fa-calculator"></i> <span>Estimaciones</span>
      </a>
      
    </li>
    <li>
      <a href="<?php echo base_url() ."prorrogas" ?>">
        <i class="fa fa-calendar-plus-o"></i> <span>Prorrogas</span>
      </a>
      
    </li>
    <li>
      <a href="<?php echo base_url() ."convenios" ?>">
        <i class="fa fa-files-o"></i> <span>Convenios</span>
      </a>
      
    </li>
    <li>
      <a href="<?php echo base_url() ."fianzas" ?>">
        <i class="fa fa-road"></i> <span>Fianzas</span>
      </a>
      
    </li>
    
  <?php endif; ?>
    
    
    
  </ul>
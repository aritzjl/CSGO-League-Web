<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:param name="temporadaSeleccionada"/>

<xsl:template match="/">
  <html>
    <head>
      <title>Clasificación de Temporadas</title>
      <script src="https://cdn.tailwindcss.com"></script> <!-- tailwindcss CDN -->
    </head>
    <body>
      <section class="w-full md:w-10/12 mt-16">
      <h2 class="mb-6 text-4xl font-extrabold leading-none tracking-tight ml-2 text-white md:text-5xl lg:text-6xl">Clasificación</h2>
      <div class="relative overflow-x-auto border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0] mb-5">
        <table id="miTabla" class="w-full text-sm text-left rtl:text-right text-white">
          <thead class="text-xs text-black uppercase bg-[#ffff09]">
            <tr>
              <th class="px-6 py-3">Posición</th>
              <th class="px-6 py-3">Escudo</th>
              <th class="px-6 py-3">Nombre</th>
              <th class="px-6 py-3">Jugados</th>
              <th class="px-6 py-3">Ganados</th>
              <th class="px-6 py-3">Perdidos</th>
              <th class="px-6 py-3">Dif. Rondas</th>
              <th class="px-6 py-3">Puntos</th>
            </tr>
          </thead>
          <tbody>
            <xsl:apply-templates select="Temporadas/Temporada[Numero=$temporadaSeleccionada]/Equipos/Equipo">
            </xsl:apply-templates>
          </tbody>
        </table>
      </div>
      </section>
    </body>
  </html>
</xsl:template>

<xsl:template match="Equipo">
  <xsl:variable name="equipoNombre" select="Nombre"/>
  <xsl:variable name="partidos" select="../../Jornadas/Jornada/Partidos/Partido"/>
  <!-- Filtrar los partidos que no han sido jugados (0-0) -->
  <xsl:variable name="partidosJugados" select="count($partidos[EquipoLocal = $equipoNombre or EquipoVisitante = $equipoNombre][PuntosLocal != 0 or PuntosVisitante != 0])"/>
  <!-- Calcular partidos ganados y partidos perdidos -->
  <xsl:variable name="partidosGanados" select="count($partidos[(EquipoLocal = $equipoNombre and PuntosLocal > PuntosVisitante) or (EquipoVisitante = $equipoNombre and PuntosVisitante > PuntosLocal)])"/>
  <xsl:variable name="partidosPerdidos" select="$partidosJugados - $partidosGanados"/>
  <!-- Calcular la diferencia de rondas -->
  <xsl:variable name="rondasAFavor" select="sum($partidos[EquipoLocal = $equipoNombre]/PuntosLocal) + sum($partidos[EquipoVisitante = $equipoNombre]/PuntosVisitante)"/>
  <xsl:variable name="rondasEnContra" select="sum($partidos[EquipoLocal = $equipoNombre]/PuntosVisitante) + sum($partidos[EquipoVisitante = $equipoNombre]/PuntosLocal)"/>
  <xsl:variable name="rounddiff" select="$rondasAFavor - $rondasEnContra"/>
  <!-- Calcular los puntos -->
  <xsl:variable name="puntos" select="$partidosGanados * 3"/>
  <!-- Comprobar si el equipo tiene partidos jugados -->
  <xsl:choose>
    <xsl:when test="$partidosJugados = 0">
      <!-- Si no hay partidos jugados, establecer valores predeterminados -->
      <tr>
        <td class="px-6 py-4"><xsl:value-of select="position()"/></td>
        <td class="px-6 py-4">
          <!-- Escudo -->
          <form action="club.php" method="post">
            <input type="hidden" name="clubID" value="{$equipoNombre}"/>
            <button type="submit" class="focus:outline-none">
              <img src="../xmlxsl/{Escudo}" alt="{Nombre}" class="w-20"/>
            </button>
          </form>
        </td>
        <td class="px-6 py-4"><xsl:value-of select="$equipoNombre"/></td>
        <!-- Indicar que no se han jugado partidos -->
        <td class="px-6 py-4">0</td>
        <td class="px-6 py-4">0</td>
        <td class="px-6 py-4">0</td>
        <td class="px-6 py-4">0</td>
        <td class="px-6 py-4">0</td>
      </tr>
    </xsl:when>
    <xsl:otherwise>
      <!-- Si hay partidos jugados, mostrar los valores calculados -->
      <tr>
        <td class="px-6 py-4"><xsl:value-of select="position()"/></td>
        <td class="px-6 py-4">
          <!-- Escudo -->
          <form action="club.php" method="post">
            <input type="hidden" name="clubID" value="{$equipoNombre}"/>
            <button type="submit" class="focus:outline-none">
              <img src="../xmlxsl/{Escudo}" alt="{Nombre}" class="w-20"/>
            </button>
          </form>
        </td>
        <td class="px-6 py-4"><xsl:value-of select="$equipoNombre"/></td>
        <td class="px-6 py-4"><xsl:value-of select="$partidosJugados"/></td>
        <td class="px-6 py-4"><xsl:value-of select="$partidosGanados"/></td>
        <td class="px-6 py-4"><xsl:value-of select="$partidosPerdidos"/></td>
        <td class="px-6 py-4"><xsl:value-of select="$rounddiff"/></td>
        <td class="px-6 py-4"><xsl:value-of select="$puntos"/></td>
      </tr>
    </xsl:otherwise>
  </xsl:choose>
</xsl:template>


</xsl:stylesheet>

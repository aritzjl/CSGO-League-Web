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
              <th class="px-6 py-3">Ver</th>
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
  <xsl:variable name="partidosJugados" select="count($partidos[EquipoLocal = $equipoNombre or EquipoVisitante = $equipoNombre])"/>
  <xsl:variable name="partidosGanados" select="count($partidos[(EquipoLocal = $equipoNombre and PuntosLocal > PuntosVisitante) or (EquipoVisitante = $equipoNombre and PuntosVisitante > PuntosLocal)])"/>
  <xsl:variable name="partidosPerdidos" select="$partidosJugados - $partidosGanados"/>
  <xsl:variable name="rondasAFavor" select="sum($partidos[EquipoLocal = $equipoNombre]/PuntosLocal) + sum($partidos[EquipoVisitante = $equipoNombre]/PuntosVisitante)"/>
  <xsl:variable name="rondasEnContra" select="sum($partidos[EquipoLocal = $equipoNombre]/PuntosVisitante) + sum($partidos[EquipoVisitante = $equipoNombre]/PuntosLocal)"/>
  <xsl:variable name="rounddiff" select="$rondasAFavor - $rondasEnContra"/>
  <xsl:variable name="puntos" select="$partidosGanados * 3"/>
  <tr>
    <td class="px-6 py-4"><xsl:value-of select="position()"/></td>
    <td class="px-6 py-4"><img src="../img/logo.png" alt="" class="w-20"/></td>
    <td class="px-6 py-4"><xsl:value-of select="$equipoNombre"/></td>
    <td class="px-6 py-4"><xsl:value-of select="$partidosJugados"/></td>
    <td class="px-6 py-4"><xsl:value-of select="$partidosGanados"/></td>
    <td class="px-6 py-4"><xsl:value-of select="$partidosPerdidos"/></td>
    <td class="px-6 py-4"><xsl:value-of select="$rounddiff"/></td>
    <td class="px-6 py-4"><xsl:value-of select="$puntos"/></td>
    <td class="px-6 py-4"><a href="ver-club.php/?id={ID}" class="inline-flex items-center justify-center px-5 py-2 text-base font-medium text-center text-gray-900 border border-gray-900 rounded-lg bg-[#ffff09] hover:border-sky-200 hover:shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">Ver</a></td>
  </tr>
</xsl:template>

</xsl:stylesheet>

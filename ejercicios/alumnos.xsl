<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"></link>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellidos</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nota</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <xsl:for-each select="alumnos/alumno">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><xsl:value-of select="nombre"/></td>
                        <td class="px-6 py-4 whitespace-nowrap"><xsl:value-of select="apellidos"/></td>
                        <td class="px-6 py-4 whitespace-nowrap"><xsl:value-of select="grupo"/></td>
                        <td class="px-6 py-4 whitespace-nowrap"><xsl:value-of select="nota"/></td>
                    </tr>
                </xsl:for-each>
            </tbody>
        </table>
    </xsl:template>
</xsl:stylesheet>

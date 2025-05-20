<!-- Antes (problema): -->
<a href="{{ route('reportes.generar', array_merge(request()->all(), ['formato' => 'excel'])) }}">Excel</a>

<!-- Ahora (solución): -->
<form action="{{ route('reportes.generar') }}" method="POST" class="m-0 p-0 inline">
    @csrf
    <!-- Preservar todos los parámetros actuales -->
    <input type="hidden" name="formato" value="excel">
    <button type="submit" class="...">Excel</button>
</form><?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class ValidateSignature extends Middleware
{
    /**
     * The names of the query string parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];
}

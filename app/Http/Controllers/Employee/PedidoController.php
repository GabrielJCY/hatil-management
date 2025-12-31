<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Mueble;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Importante: Asegúrate de haber instalado dompdf con composer
use Barryvdh\DomPDF\Facade\Pdf;

class PedidoController extends Controller
{
    /**
     * Listado de pedidos
     */
    public function index()
    {
        // CORRECCIÓN: Se cambió 'cliente' por 'usuario'
        $pedidos = Pedido::with('usuario')
            ->orderBy('Fecha_pedido', 'desc')
            ->paginate(10);
        
        return view('employee.pedidos.index', compact('pedidos'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        // Traemos usuarios que no sean admin para el select de clientes
        $clientes = User::where('rol_type', '!=', 'admin')->get();
        $muebles = Mueble::all();

        return view('employee.pedidos.create', compact('clientes', 'muebles'));
    }

    /**
     * Guardar pedido y sus detalles
     */
    public function store(Request $request)
    {
        $request->validate([
            'UsuarioC_id' => 'required',
            'Metodo_pago' => 'required',
            'Direccion_envio' => 'required|max:100',
            'muebles' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $pedido = Pedido::create([
                'UsuarioC_id'     => $request->UsuarioC_id,
                'UsuarioEmp_id'   => auth()->id(), 
                'Fecha_pedido'    => now(),
                'Estado'          => 'Pendiente',
                'Metodo_pago'     => $request->Metodo_pago,
                'Direccion_envio' => $request->Direccion_envio,
                'Total'           => 0 
            ]);

            $totalAcumulado = 0;

            foreach ($request->muebles as $item) {
                $mueble = Mueble::findOrFail($item['Mueble_id']);
                $subtotal = $mueble->Precio * $item['Cantidad'];

                // Usamos el nombre de la tabla Detalle_Pedido tal cual está en tu SQL
                DB::table('Detalle_Pedido')->insert([
                    'Pedido_id'       => $pedido->Pedido_id,
                    'Mueble_id'       => $mueble->Mueble_id,
                    'UsuarioC_id'     => $request->UsuarioC_id,
                    'Cantidad'        => $item['Cantidad'],
                    'Precio_Unitario' => $mueble->Precio,
                    'created_at'      => now(),
                    'updated_at'      => now()
                ]);

                $totalAcumulado += $subtotal;
            }

            $pedido->update(['Total' => $totalAcumulado]);

            DB::commit();
            return redirect()->route('admin.pedidos.index')->with('success', 'Pedido creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de un pedido
     */
    public function show($id)
    {
        // CORRECCIÓN: Se cambió 'cliente' por 'usuario'
        $pedido = Pedido::with(['usuario', 'detalles.mueble'])->findOrFail($id);
        return view('employee.pedidos.show', compact('pedido'));
    }

    /**
     * Formulario de edición (Estado)
     */
    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        return view('employee.pedidos.edit', compact('pedido'));
    }

    /**
     * Actualizar estado del pedido
     */
    public function update(Request $request, $id)
    {
        $request->validate(['Estado' => 'required']);
        $pedido = Pedido::findOrFail($id);
        $pedido->update($request->only('Estado'));

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido actualizado.');
    }

    /**
     * Generar y descargar Factura PDF
     */
    public function generatePdf($id)
    {
        // CORRECCIÓN: Se cambió 'cliente' por 'usuario'
        $pedido = Pedido::with(['usuario', 'detalles.mueble'])->findOrFail($id);
        
        $pdf = Pdf::loadView('employee.pedidos.pdf', compact('pedido'));

        return $pdf->download('Factura_HATIL_Nro_'.$pedido->Pedido_id.'.pdf');
    }

    /**
     * Eliminar pedido
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            DB::table('Detalle_Pedido')->where('Pedido_id', $id)->delete();
            Pedido::findOrFail($id)->delete();
            DB::commit();
            return redirect()->route('admin.pedidos.index')->with('success', 'Pedido eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}
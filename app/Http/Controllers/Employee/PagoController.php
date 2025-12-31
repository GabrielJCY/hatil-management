<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PagoController extends Controller
{
    /**
     * Listado de pagos con buscador por ID de pedido.
     */
    public function index(Request $request)
    {
        $query = Pago::with('pedido.usuario')->orderBy('Fecha_pago', 'desc');

        if ($request->has('pedido_id') && $request->pedido_id != '') {
            $query->where('Pedido_id', $request->pedido_id);
        }

        $pagos = $query->paginate(15)->withQueryString();

        // Nota: Asegúrate de que la vista esté en resources/views/employee/pagos/index.blade.php
        return view('employee.pagos.index', compact('pagos'));
    }

    /**
     * Mostrar formulario para registrar un nuevo pago.
     */
    public function create(Request $request)
    {
        $selectedPedidoId = $request->get('pedido_id');
        
        // Obtenemos los pedidos activos con sus relaciones para el selector
        $pedidos = Pedido::select('Pedido_id', 'UsuarioC_Id', 'Total') 
            ->with(['usuario' => function ($query) {
                $query->select('id', 'name'); 
            }])
            ->where('Estado', '!=', 'Cancelado')
            ->get();
        
        $metodos = ['Efectivo', 'Tarjeta de Crédito', 'Transferencia Bancaria', 'PayPal', 'Otro'];
        $estados = ['Completado', 'Pendiente', 'Fallido', 'Aprobado'];
        
        return view('employee.pagos.create', compact('pedidos', 'selectedPedidoId', 'metodos', 'estados'));
    }

    /**
     * Guardar el nuevo pago en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Pedido_id'   => ['required', 'exists:pedidos,Pedido_id'],
            'Monto'       => ['required', 'numeric', 'min:0.01'],
            'Metodo_Pago' => ['required', 'string', 'max:50'], // P mayúscula
            'Fecha_Pago'  => ['required', 'date'],
            'Estado_Pago' => ['required', 'string', Rule::in(['Completado', 'Pendiente', 'Fallido', 'Aprobado'])], 
        ]);
        
        // Mapeo exacto de los datos validados a las columnas de la DB
        $pago = Pago::create([
            'Pedido_id'   => $validatedData['Pedido_id'],
            'Monto'       => $validatedData['Monto'],
            'Metodo_Pago' => $validatedData['Metodo_Pago'],
            'Estado'      => $validatedData['Estado_Pago'],
            'Fecha_pago'  => $validatedData['Fecha_Pago'],
        ]); 

        return redirect()->route('admin.pagos.index') 
                         ->with('success', "El pago #{$pago->Pago_id} ha sido registrado con éxito en Bs.");
    }

    /**
     * Redirigir a la edición del pago.
     */
    public function show(Pago $pago)
    {
        return redirect()->route('admin.pagos.edit', $pago->Pago_id);
    }

    /**
     * Mostrar formulario de edición del pago.
     */
    public function edit(Pago $pago)
    {
        // Cargamos todos los pedidos para el selector en caso de reasignación
        $pedidos = Pedido::select('Pedido_id', 'UsuarioC_Id', 'Total')
            ->with(['usuario' => function ($query) {
                $query->select('id', 'name'); 
            }])
            ->get();
        
        $metodos = ['Efectivo', 'Tarjeta de Crédito', 'Transferencia Bancaria', 'PayPal', 'Otro'];
        $estados = ['Completado', 'Pendiente', 'Fallido', 'Aprobado'];

        return view('employee.pagos.edit', compact('pago', 'pedidos', 'metodos', 'estados'));
    }

    /**
     * Actualizar los datos del pago.
     */
    public function update(Request $request, Pago $pago)
    {
        $validatedData = $request->validate([
            'Pedido_id'   => ['required', 'exists:pedidos,Pedido_id'],
            'Monto'       => ['required', 'numeric', 'min:0.01'],
            'Metodo_Pago' => ['required', 'string', 'max:50'], // P mayúscula
            'Fecha_Pago'  => ['required', 'date'],
            'Estado_Pago' => ['required', 'string', Rule::in(['Completado', 'Pendiente', 'Fallido', 'Aprobado'])], 
        ]);
        
        $pago->update([
            'Pedido_id'   => $validatedData['Pedido_id'],
            'Monto'       => $validatedData['Monto'],
            'Metodo_Pago' => $validatedData['Metodo_Pago'],
            'Estado'      => $validatedData['Estado_Pago'],
            'Fecha_pago'  => $validatedData['Fecha_Pago'],
        ]); 

        return redirect()->route('admin.pagos.index')
                         ->with('success', "El pago #{$pago->Pago_id} ha sido actualizado correctamente.");
    }

    /**
     * Eliminar pago de forma segura usando transacciones.
     */
    public function destroy(Pago $pago)
    {
        try {
            DB::transaction(function () use ($pago) {
                // 1. Limpiamos las referencias en Detalle_Pedido antes de borrar el pago
                DB::table('Detalle_Pedido')
                    ->where('Pago_id', $pago->Pago_id)
                    ->update(['Pago_id' => null]);

                // 2. Eliminamos el pago físicamente
                $pago->delete();
            });

            return redirect()->route('admin.pagos.index')
                             ->with('success', "El pago #{$pago->Pago_id} ha sido eliminado del sistema.");

        } catch (\Exception $e) {
            return redirect()->route('admin.pagos.index')
                             ->with('error', "No se pudo eliminar el registro: " . $e->getMessage());
        }
    }
}
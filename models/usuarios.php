<?php
require_once("../connection/Connection.php");
// 
class Base extends Conectar{
            // 
            public function get_user($cedula)
            {
            $conectar = parent::conexion();
            parent::set_names();
            // $sql="EXEC [dbo].[sp_pagosrecover] '$cedula'";
            $sql="CALL dwh_icesa.proc_contin_pagos_refi_2('$cedula')";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_OBJ);
            }
            public function get_user2($cedula)
            {
            $conectar = parent::conexion();
            parent::set_names();
            // $sql="EXEC [dbo].[sp_pagosrecover] '$cedula'";
            $sql="SELECT
                        numeroCredito as id,
                        '02/02/2023' as fecha_vencimiento,
                        -- saldoCartera as saldo_cartera, 
                        valorVencido as val_vencido,
                        valorCuota as val_cuota,
                        diasAtraso as días_mora,
                        -- gastoCobranza as gastos_cobranzas,
                        valorDeuda as val_deuda,
                        gastoCobranza as val_vencido_total,
                        valorTotalPagar as total_pagar
                        
                        from dwh_icesa.datos_cobranza_pendiente_tbl where cedulaCliente = '$cedula'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_OBJ);
            }
        }

?>
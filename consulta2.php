<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lista de Usuarios</title>
	<style>
		table {
			width: 80%;
			margin: 20px auto;
			border-collapse: collapse;
		}

		th,
		td {
			border: 2px solid gray;
			padding: 10px;
			text-align: center;
		}

		th {
			background: blue;
			color: white;
			text-shadow: 1px 1px 2px black;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		tr:hover {
			background-color: #ddd;
		}
	</style>
</head>

<body>

	<h1 style="text-align: center; margin-top: 20px;">Lista de Usuarios</h1>
		<tbody>
			<?php
			include 'db.php';
			try {
				// Ejecutar la consulta
				$consulta = $pdo->query("SELECT username, edad, fecha, vip, provincia FROM users");
			
				echo '<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 80%; margin: auto; text-align: center;">
						<thead>
							<tr style="background-color: #4A90E2; color: white;">
								<th>Nombre</th>
								<th>Edad</th>
								<th>Fecha</th>
								<th>VIP</th>
								<th>Provincia</th>
							</tr>
						</thead>
						<tbody>';
			
				// Mostrar los resultados
				while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
					echo "<tr>
							<td>" . htmlspecialchars($registro['username']) . "</td>
							<td>" . htmlspecialchars($registro['edad']) . "</td>
							<td>" . htmlspecialchars($registro['fecha']) . "</td>
							<td>" . htmlspecialchars($registro['vip']) . "</td>
							<td>" . htmlspecialchars($registro['provincia']) . "</td>
						  </tr>";
				}
			
				echo '</tbody></table>';
			
			} catch (PDOException $e) {
				die("Error en la consulta: " . $e->getMessage());
			}
			?>
		</tbody>
	</table>

</body>

</html>
		Func FindThunderbird()
			Global $ThunderbirdVersion = "Thunderbird 3.1.9"
			Global $ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.9\bin", "PathToExe")
			If @error Then
				$ThunderbirdVersion = "Thunderbird 3.1.8"
				$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.8\bin", "PathToExe")
				If @error Then
					$ThunderbirdVersion = "Thunderbird 3.1.7"
					$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.7\bin", "PathToExe")
					If @error Then
						$ThunderbirdVersion = "Thunderbird 3.1.6"
						$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.6\bin", "PathToExe")
						If @error Then
							$ThunderbirdVersion = "Thunderbird 3.1.5"
							$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.5\bin", "PathToExe")
							If @error Then
								$ThunderbirdVersion = "Thunderbird 3.1.4"
								$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.4\bin", "PathToExe")
								If @error Then
									$ThunderbirdVersion = "Thunderbird 3.1.3"
									$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.3\bin", "PathToExe")
									If @error Then
										$ThunderbirdVersion = "Thunderbird 3.1.2"
										$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.2\bin", "PathToExe")
										If @error Then
											$ThunderbirdVersion = "Thunderbird 3.1.1"
											$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1.1\bin", "PathToExe")
											If @error Then
												$ThunderbirdVersion = "Thunderbird 3.1"
												$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.1\bin", "PathToExe")
												If @error Then
													$ThunderbirdVersion = "Thunderbird 3.0.11"
													$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.11\bin", "PathToExe")
													If @error Then
														$ThunderbirdVersion = "Thunderbird 3.0.10"
														$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.10\bin", "PathToExe")
														If @error Then
															$ThunderbirdVersion = "Thunderbird 3.0.9"
															$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.9\bin", "PathToExe")
															If @error Then
																$ThunderbirdVersion = "Thunderbird 3.0.8"
																$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.8\bin", "PathToExe")
																If @error Then	
																	$ThunderbirdVersion = "Thunderbird 3.0.7"
																	$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.7\bin", "PathToExe")
																	If @error Then
																		$ThunderbirdVersion = "Thunderbird 3.0.6"
																		$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.6\bin", "PathToExe")
																		If @error Then
																			$ThunderbirdVersion = "Thunderbird 3.0.5"
																			$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.5\bin", "PathToExe")
																			If @error Then
																				$ThunderbirdVersion = "Thunderbird 3.0.4"
																				$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.4\bin", "PathToExe")
																				If @error Then
																					$ThunderbirdVersion = "Thunderbird 3.0.3"
																					$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.3\bin", "PathToExe")
																					If @error Then
																						$ThunderbirdVersion = "Thunderbird 3.0.1"
																						$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0.1\bin", "PathToExe")
																						If @error Then
																							$ThunderbirdVersion = "Thunderbird 3.0"
																							$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 3.0\bin", "PathToExe")
																							If @error Then
																								$ThunderbirdVersion = "Thunderbird 2.0.0.23"
																								$ThunderbirdRegPath = RegRead("HKEY_LOCAL_MACHINE\SOFTWARE\Mozilla\Mozilla Thunderbird 2.0.0.23\bin", "PathToExe")
																								If @error Then
																									$ThunderbirdRegPath = -1
																									$ThunderbirdVersion = -1
																								EndIf
																							EndIf
																						EndIf
																					EndIf
																				EndIf
																			EndIf
																		EndIf
																	EndIf
																EndIf
															EndIf
														EndIf
													EndIf
												EndIf
											EndIf
										EndIf
									EndIf
								EndIf
							EndIf
						EndIf
					EndIf
				EndIf
			EndIf
		EndFunc
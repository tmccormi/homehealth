' NOTE: You can use the "Rename" command on the context menu to change the class name "Service1" in code, svc and config file together.
Imports HealthCareSynergyLogin
Imports HSIAccess
Imports HSIProvider
Imports HealthCareSynergyPatientsCharts
Imports HSIPatientRepository
Imports HSIDictionaries
Imports HSIPatientInsurance

Imports HSIReferralSource
Imports HealthCareAssistant
Imports HealthCareSynergyDictionaries
Imports HSIChartUtilities
Imports Ledger
Imports HSIInsurance
Imports HealthCareSynergyOASIS
Imports HSIPatientChart
Imports HSIOasisEvaluation
Imports System.Data

Imports System
Imports System.ServiceModel
Imports System.ServiceModel.Channels
Imports System.Web.Services.Description

Namespace Msdn.Web.Services.Samples
    Public Class HttpsReflector
        Inherits SoapExtensionReflector
        Public Overrides Sub ReflectMethod()
            'no-op
        End Sub

        Public Overrides Sub ReflectDescription()
            Dim description As ServiceDescription = ReflectionContext.ServiceDescription
            For Each service As Service In description.Services
                For Each port As Port In service.Ports
                    For Each extension As ServiceDescriptionFormatExtension In port.Extensions
                        Dim binding As SoapAddressBinding = TryCast(extension, SoapAddressBinding)
                        If binding IsNot Nothing Then
                            binding.Location = binding.Location.Replace("http://", "https://")
                        End If
                    Next
                Next
            Next
        End Sub
    End Class
End Namespace

<ServiceModel.ServiceBehavior(Namespace:="HealthcareSynergy")>
Public Class Service
    Implements IService

    Public Sub New()
    End Sub

    Public Function LoginAdmin(ByVal username As String, ByVal password As String, ByVal agency_id As String) As String Implements IService.LoginAdmin

        Dim response As List(Of HomeHealthAgency)
        Dim login_obj As Object = New HealthCareSynergyLogin.Login
        response = login_obj.LoginAndReturnListOfAgencies(username, password)
        Dim ret_string As String ' = response.Item(0).Label.AgencyCode
        Dim ag_flag As String
        Dim agency_ids As String
        agency_ids = ""
        Dim eachCount As Integer
        eachCount = 1
        If response.Count > 1 Then
            For Each ag In response
                If eachCount > 1 Then
                    agency_ids = agency_ids & ", " & ag.AgencyCode
                Else
                    agency_ids = agency_ids & ag.AgencyCode
                End If
                If ag.AgencyCode = agency_id Then
                    ret_string = ag.AgencyCode
                    login_obj.SelectAgencyAndConnectToDatabase(ag)
                    ag_flag = 1
                End If
                eachCount = eachCount + 1
            Next
            If ag_flag <> 1 Then
                Throw New System.Exception("Agency Login Information and Agency ID Does Not Match. Available Agency IDs for the given Login Information are: " & agency_ids)
            End If
        Else
            If agency_id = response.Item(0).Label.AgencyCode Then
                ret_string = response.Item(0).Label.AgencyCode
            Else
                Throw New System.Exception("Agency Login Information and Agency ID Does Not Match." & Environment.NewLine &
        "Given Agency ID: " & agency_id & " Available Agency ID: " & response.Item(0).Label.AgencyCode)
            End If
        End If

        Return ret_string

    End Function

    Public Function AddDemographics(ByVal username As String, ByVal password As String, ByVal patient_data() As String) As Patient Implements IService.AddDemographics
        Dim agency_id As String
        agency_id = LoginAdmin(username, password, patient_data(6))

        Dim agen_id As SynergyID
        agen_id = New SynergyID(agency_id)
        Dim Agency As New AgencyLabel(agen_id, patient_data(7))
        'login_obj.SelectAgencyAndConnectToDatabase(response.Item(0))

        Dim default_patient As Patient
        Dim patient_obj As Object = New HealthCareSynergyPatientsCharts.HCSPatient
        Try
            default_patient = patient_obj.RetrievePatientDefaultWithCode(agency_id, patient_data(14))
        Catch ex As Exception
            Throw New Exception("Given Patient ID already exist in Synergy")
        End Try
        default_patient.Address.Address1 = patient_data(0)
        default_patient.Address.Address2 = patient_data(1)
        default_patient.Address.City = patient_data(2)
        default_patient.Address.State = patient_data(3)
        default_patient.Address.Zip = patient_data(4)
        default_patient.Birthdate = patient_data(8)
        default_patient.FullName.FirstName = patient_data(9)
        default_patient.FullName.MiddleInitial = patient_data(10)
        default_patient.FullName.LastName = patient_data(11)
        default_patient.Gender = patient_data(12)
        default_patient.SSN.Number = patient_data(15)
        default_patient.Telephone.Number = patient_data(16)
        default_patient.Workphone.Number = patient_data(17)
        default_patient.Employer = patient_data(20)
        default_patient.Ethnicity = default_patient.Ethnicity(patient_data(21))
        default_patient.Language = default_patient.Language(patient_data(22))
        default_patient.Notes = patient_data(23)
        default_patient.MaritalStatus = default_patient.MaritalStatus(patient_data(24))
        default_patient.Occupation = patient_data(25)
        default_patient.EmploymentStatus = default_patient.EmploymentStatus(3)

        Dim doc_obj As Object = New HSIProvider.Physician
        Dim doc_return As List(Of HSIProvider.Physician)
        Dim doc_1 As HSIProvider.Physician
        Dim doc_id As SynergyUserID
        Dim doc_flag As Integer
        doc_return = doc_obj.GetPhysicianList()
        For Each this_doc In doc_return
            If this_doc.ProviderCode.ID = patient_data(19) Then
                doc_1 = this_doc
                doc_id = doc_1.ProviderCode
                doc_flag = 1
                Exit For
            End If
        Next

        If doc_flag <> 1 And patient_data(19) <> "" Then
            Throw New Exception("Given Other Physician ID for the selected Agency does not match with Synergy")
        Else
            default_patient.DoctorCode = doc_id
        End If
        'phy_id = phy_1.ProviderCode


        Dim ref_obj As Object = New HSIReferralSource.ReferralSourceRepository
        Dim ref_return As List(Of HSIReferralSource.ReferralSource)
        ref_return = ref_obj.RetrieveReferralSources(patient_data(6))
        Dim ref_1 As HSIReferralSource.ReferralSource
        Dim ref_id As SynergyUserID
        Dim ref_flag As Integer
        For Each ref_src In ref_return
            If ref_src.ReferralCode.ID = patient_data(28) Then
                ref_1 = ref_src
                ref_id = ref_1.ReferralCode
                ref_flag = 1
                Exit For
            End If
        Next
        'ref_id = ref_1.ReferralCode
        If ref_flag <> 1 Then
            Throw New Exception("Given Referring Physician ID for the selected Agency does not match with Synergy")
        Else
            default_patient.ReferralCode = ref_id
        End If


        Dim phy_obj As Object = New HSIProvider.Physician
        Dim phy_return As List(Of HSIProvider.Physician)
        Dim phy_1 As HSIProvider.Physician
        Dim phy_id As SynergyUserID
        Dim phy_flag As Integer
        phy_return = phy_obj.GetPhysicianList()
        For Each prim_doc In phy_return
            If prim_doc.ProviderCode.ID = patient_data(27) Then
                phy_1 = prim_doc
                phy_id = phy_1.ProviderCode
                phy_flag = 1
                Exit For
            End If
        Next

        If phy_flag <> 1 Then
            Throw New Exception("Given Physician ID for the selected Agency does not match with Synergy")
        Else
            default_patient.PrimaryDoctorCode = phy_id
        End If


        default_patient.AssociatedAgency = Agency
        default_patient.OfficeCode = "1"

        Try
            patient_obj.CreatePatient(default_patient)
        Catch ex As Exception
            Throw New Exception(ex.Message)
        End Try

        'To append Primary Insurance data
        If patient_data(44) <> "" Then
            Dim CRUD As New HCSPatientInsurance
            Dim PatientCode As String = patient_data(14)
            Dim patientInsurance As PatientInsurance = CRUD.RetrievePatientInsuranceDefault(New SynergyUserID(PatientCode))
            patientInsurance.InsuranceType = patientInsurance.InsuranceType.ItemByDescription(patient_data(41))

            Dim mydate As String = patient_data(8)
            Dim dat As Date
            dat = DateTime.Parse(mydate)
            patientInsurance.InsuredBirthdate = New SynergyDate(dat)

            If patient_data(12) = "Male" Then
                patientInsurance.GenderCode = patientInsurance.GenderCode.Item(1)
            Else
                patientInsurance.GenderCode = patientInsurance.GenderCode.Item(2)
            End If

            patientInsurance.InsuredEmployer_SchoolName = patient_data(42)
            patientInsurance.InsuredFirstName = patient_data(9)
            patientInsurance.InsuredLastName = patient_data(11)
            patientInsurance.InsuredMiddleName = patient_data(10)

            Dim medeff_date_formatted As Date
            If patient_data(43) <> "" Then
                Dim medeff_date As String = patient_data(43)
                medeff_date_formatted = DateTime.Parse(medeff_date)
                patientInsurance.MedicaidEffectiveDateFrom = New SynergyDate(medeff_date_formatted)
            End If

            patientInsurance.InsuranceCode = New SynergyUserID(patient_data(44))
            patientInsurance.InsuredRelationship = patientInsurance.InsuredRelationship.Item(1)
            patientInsurance.UsePatientInfo = True
            patientInsurance.UsePatientAddress = True
            patientInsurance.PatientName = patient_data(9) & patient_data(10)
            patientInsurance.PlanName = patient_data(45)
            patientInsurance.Policy = patient_data(46)
            If patient_data(47) = "2" Then
                patientInsurance.PartA = True
                If patient_data(43) <> "" Then
                    patientInsurance.PartAStartDate = New SynergyDate(medeff_date_formatted)
                End If
            ElseIf patient_data(47) = "3" Then
                patientInsurance.PartB = True
                If patient_data(43) <> "" Then
                    patientInsurance.PartBStartDate = New SynergyDate(medeff_date_formatted)
                End If
            Else
                patientInsurance.PartA = False
                patientInsurance.PartB = False
            End If

            Try
                CRUD.CreatePatientInsurance(patientInsurance)
            Catch ex As Exception
                Try
                    CRUD.CreatePatientInsuranceWithWarnings(patientInsurance)
                Catch ex_2 As Exception
                    Throw New Exception(ex_2.Message)
                End Try
            End Try
        End If

        'To append Secondary Insurance data
        If patient_data(54) <> "" Then
            Dim CRUD As New HCSPatientInsurance
            Dim PatientCode As String = patient_data(14)
            Dim patientInsurance As PatientInsurance = CRUD.RetrievePatientInsuranceDefault(New SynergyUserID(PatientCode))
            patientInsurance.InsuranceType = patientInsurance.InsuranceType.ItemByDescription(patient_data(51))

            Dim mydate As String = patient_data(8)
            Dim dat As Date
            dat = DateTime.Parse(mydate)
            patientInsurance.InsuredBirthdate = New SynergyDate(dat)

            If patient_data(12) = "Male" Then
                patientInsurance.GenderCode = patientInsurance.GenderCode.Item(1)
            Else
                patientInsurance.GenderCode = patientInsurance.GenderCode.Item(2)
            End If

            patientInsurance.InsuredEmployer_SchoolName = patient_data(52)
            patientInsurance.InsuredFirstName = patient_data(9)
            patientInsurance.InsuredLastName = patient_data(11)
            patientInsurance.InsuredMiddleName = patient_data(10)

            Dim medeff_date_formatted As Date
            If patient_data(53) <> "" Then
                Dim medeff_date As String = patient_data(53)
                medeff_date_formatted = DateTime.Parse(medeff_date)
                patientInsurance.MedicaidEffectiveDateFrom = New SynergyDate(medeff_date_formatted)
            End If

            patientInsurance.InsuranceCode = New SynergyUserID(patient_data(54))
            patientInsurance.InsuredRelationship = patientInsurance.InsuredRelationship.Item(1)
            patientInsurance.UsePatientInfo = True
            patientInsurance.UsePatientAddress = True
            patientInsurance.PatientName = patient_data(9) & patient_data(10)
            patientInsurance.PlanName = patient_data(55)
            patientInsurance.Policy = patient_data(56)
            If patient_data(57) = "2" Then
                patientInsurance.PartA = True
                If patient_data(53) <> "" Then
                    patientInsurance.PartAStartDate = New SynergyDate(medeff_date_formatted)
                End If
            ElseIf patient_data(57) = "3" Then
                patientInsurance.PartB = True
                If patient_data(53) <> "" Then
                    patientInsurance.PartBStartDate = New SynergyDate(medeff_date_formatted)
                End If
            Else
                patientInsurance.PartA = False
                patientInsurance.PartB = False
            End If

            Try
                CRUD.CreatePatientInsurance(patientInsurance)
            Catch ex As Exception
                Try
                    CRUD.CreatePatientInsuranceWithWarnings(patientInsurance)
                Catch ex_2 As Exception
                    Throw New Exception(ex_2.Message)
                End Try
            End Try
        End If
        'To append Tertiary Insurance data
        If patient_data(64) <> "" Then
            Dim CRUD As New HCSPatientInsurance
            Dim PatientCode As String = patient_data(14)
            Dim patientInsurance As PatientInsurance = CRUD.RetrievePatientInsuranceDefault(New SynergyUserID(PatientCode))
            patientInsurance.InsuranceType = patientInsurance.InsuranceType.ItemByDescription(patient_data(61))

            Dim mydate As String = patient_data(8)
            Dim dat As Date
            dat = DateTime.Parse(mydate)
            patientInsurance.InsuredBirthdate = New SynergyDate(dat)

            If patient_data(12) = "Male" Then
                patientInsurance.GenderCode = patientInsurance.GenderCode.Item(1)
            Else
                patientInsurance.GenderCode = patientInsurance.GenderCode.Item(2)
            End If

            patientInsurance.InsuredEmployer_SchoolName = patient_data(62)
            patientInsurance.InsuredFirstName = patient_data(9)
            patientInsurance.InsuredLastName = patient_data(11)
            patientInsurance.InsuredMiddleName = patient_data(10)

            Dim medeff_date_formatted As Date
            If patient_data(63) <> "" Then
                Dim medeff_date As String = patient_data(63)
                medeff_date_formatted = DateTime.Parse(medeff_date)
                patientInsurance.MedicaidEffectiveDateFrom = New SynergyDate(medeff_date_formatted)
            End If

            patientInsurance.InsuranceCode = New SynergyUserID(patient_data(64))
            patientInsurance.InsuredRelationship = patientInsurance.InsuredRelationship.Item(1)
            patientInsurance.UsePatientInfo = True
            patientInsurance.UsePatientAddress = True
            patientInsurance.PatientName = patient_data(9) & patient_data(10)
            patientInsurance.PlanName = patient_data(65)
            patientInsurance.Policy = patient_data(66)
            If patient_data(67) = "2" Then
                patientInsurance.PartA = True
                If patient_data(63) <> "" Then
                    patientInsurance.PartAStartDate = New SynergyDate(medeff_date_formatted)
                End If
            ElseIf patient_data(67) = "3" Then
                patientInsurance.PartB = True
                If patient_data(63) <> "" Then
                    patientInsurance.PartBStartDate = New SynergyDate(medeff_date_formatted)
                End If
            Else
                patientInsurance.PartA = False
                patientInsurance.PartB = False
            End If

            Try
                CRUD.CreatePatientInsurance(patientInsurance)
            Catch ex As Exception
                Try
                    CRUD.CreatePatientInsuranceWithWarnings(patientInsurance)
                Catch ex_2 As Exception
                    Throw New Exception(ex_2.Message)
                End Try
            End Try
        End If
        Return default_patient
    End Function
    Public Function EditDemographics(ByVal username As String, ByVal password As String, ByVal patient_data() As String) As Patient Implements IService.EditDemographics

        'Throw New System.Exception("Break the flow here")

        Dim agency_id As String
        agency_id = LoginAdmin(username, password, patient_data(6))

        Dim SynergyID As SynergyUserID
        Dim WorkingPatient As New HCSPatient
        Dim UpdatingPatient As Patient
        SynergyID = GetPatientID(patient_data(14))

        UpdatingPatient = WorkingPatient.RetrievePatient(SynergyID)

        Dim patient_obj As Object = New HealthCareSynergyPatientsCharts.HCSPatient
        UpdatingPatient.Address.Address1 = patient_data(0)
        UpdatingPatient.Address.Address2 = patient_data(1)
        UpdatingPatient.Address.City = patient_data(2)
        UpdatingPatient.Address.State = patient_data(3)
        UpdatingPatient.Address.Zip = patient_data(4)
        UpdatingPatient.Birthdate = patient_data(8)
        UpdatingPatient.FullName.FirstName = patient_data(9)
        UpdatingPatient.FullName.MiddleInitial = patient_data(10)
        UpdatingPatient.FullName.LastName = patient_data(11)
        UpdatingPatient.Gender = patient_data(12)
        UpdatingPatient.SSN.Number = patient_data(15)
        UpdatingPatient.Telephone.Number = patient_data(16)
        UpdatingPatient.Workphone.Number = patient_data(17)
        UpdatingPatient.Employer = patient_data(20)
        UpdatingPatient.Ethnicity = UpdatingPatient.Ethnicity(patient_data(21))
        UpdatingPatient.Language = UpdatingPatient.Language(patient_data(22))
        UpdatingPatient.Notes = patient_data(23)
        UpdatingPatient.MaritalStatus = UpdatingPatient.MaritalStatus(patient_data(24))
        UpdatingPatient.Occupation = patient_data(25)
        UpdatingPatient.EmploymentStatus = UpdatingPatient.EmploymentStatus(3)

        Dim doc_obj As Object = New HSIProvider.Physician
        Dim doc_return As List(Of HSIProvider.Physician)
        Dim doc_1 As HSIProvider.Physician
        Dim doc_id As SynergyUserID
        Dim doc_flag As Integer
        doc_return = doc_obj.GetPhysicianList()
        For Each this_doc In doc_return
            If this_doc.ProviderCode.ID = patient_data(19) Then
                doc_1 = this_doc
                doc_id = doc_1.ProviderCode
                doc_flag = 1
                Exit For
            End If
        Next
        If doc_flag <> 1 And patient_data(19) <> "" Then
            Throw New Exception("Given Other Physician ID for the selected Agency does not match with Synergy")
        Else
            UpdatingPatient.DoctorCode = doc_id
        End If



        Dim ref_obj As Object = New HSIReferralSource.ReferralSourceRepository
        Dim ref_return As List(Of HSIReferralSource.ReferralSource)
        ref_return = ref_obj.RetrieveReferralSources(patient_data(6))
        Dim ref_1 As HSIReferralSource.ReferralSource
        Dim ref_id As SynergyUserID
        Dim ref_flag As Integer
        For Each ref_src In ref_return
            If ref_src.ReferralCode.ID = patient_data(28) Then
                ref_1 = ref_src
                ref_id = ref_1.ReferralCode
                ref_flag = 1
                Exit For
            End If
        Next
        If ref_flag <> 1 Then
            Throw New Exception("Given Referring Physician ID for the selected Agency does not match with Synergy")
        Else
            UpdatingPatient.ReferralCode = ref_id
        End If


        Dim phy_obj As Object = New HSIProvider.Physician
        Dim phy_return As List(Of HSIProvider.Physician)
        Dim phy_1 As HSIProvider.Physician
        Dim phy_id As SynergyUserID
        Dim phy_flag As Integer
        phy_return = phy_obj.GetPhysicianList()
        For Each prim_doc In phy_return
            If prim_doc.ProviderCode.ID = patient_data(27) Then
                phy_1 = prim_doc
                phy_id = phy_1.ProviderCode
                phy_flag = 1
                Exit For
            End If
        Next
        If phy_flag <> 1 Then
            Throw New Exception("Given Physician ID for the selected Agency does not match with Synergy")
        Else
            UpdatingPatient.PrimaryDoctorCode = phy_id
        End If


        Dim agen_id As SynergyID
        agen_id = New SynergyID(agency_id)
        Dim Agency As New AgencyLabel(agen_id, patient_data(7))
        UpdatingPatient.AssociatedAgency = Agency
        UpdatingPatient.OfficeCode = "1"

        Try
            patient_obj.UpdatePatient(UpdatingPatient)
        Catch ex As Exception
            Throw New Exception(ex.Message)
        End Try

        Return UpdatingPatient

    End Function

    'Delete Patient
    Public Function DeleteDemographics(ByVal username As String, ByVal password As String, ByVal patient_id As String, ByVal agency_code As String) As String Implements IService.DeleteDemographics

        Dim agency_id As String
        agency_id = LoginAdmin(username, password, agency_code)
        Dim SynergyID As SynergyUserID
        Dim Patienthcs As New HCSPatient
        Dim RetrievedPatient As Patient
        SynergyID = GetPatientID(patient_id)
        RetrievedPatient = Patienthcs.RetrievePatient(SynergyID)

        Try
            Patienthcs.DeletePatient(RetrievedPatient)
        Catch ex As Exception
            Throw New Exception(ex.Message)
        End Try

        Return "Success"
    End Function
    'For Oasis
    Public Function ImportAnAssessment(ByVal username As String, ByVal password As String, ByVal oasis_data() As String) As Integer Implements IService.ImportAnAssessment

        Dim agency_id As String
        agency_id = LoginAdmin(username, password, oasis_data(0))
        Dim AssessmentImport = New HealthCareSynergyOASIS.OASISAnd485Import(agency_id, oasis_data(1), "", "")

        AssessmentImport.AdmissionSourceCode = oasis_data(2)

        AssessmentImport.Allergies = oasis_data(3)

        AssessmentImport.AP = oasis_data(4)

        AssessmentImport.AP_Desc = oasis_data(5)

        AssessmentImport.AssessmentFormType = oasis_data(6)

        AssessmentImport.B1 = oasis_data(7)

        AssessmentImport.Caregiver_Signed = oasis_data(8)

        AssessmentImport.CertStart = oasis_data(11)

        AssessmentImport.CertEnd = oasis_data(9)

        AssessmentImport.Certification = oasis_data(10)

        AssessmentImport.DateLastContactedPhysician = oasis_data(12)

        AssessmentImport.DateLastSeenByPhysician = oasis_data(13)

        AssessmentImport.DiagCodes = oasis_data(14)

        AssessmentImport.DiagOnset = oasis_data(15)

        AssessmentImport.DxIndicators = oasis_data(16)

        AssessmentImport.DR_ADDR1 = oasis_data(17)

        AssessmentImport.DR_ADDR2 = oasis_data(18)

        AssessmentImport.DR_CITY = oasis_data(19)

        AssessmentImport.DR_ID = oasis_data(20)

        AssessmentImport.DR_Name = oasis_data(21)

        AssessmentImport.DR_PHONE = oasis_data(22)

        AssessmentImport.DR_STATE = oasis_data(23)

        AssessmentImport.DR_UPIN = oasis_data(24)

        AssessmentImport.DR_ZIP = oasis_data(25)

        AssessmentImport.FL = oasis_data(26)

        AssessmentImport.FL_Desc = oasis_data(27)

        AssessmentImport.FormType = oasis_data(28)

        AssessmentImport.Goals = oasis_data(29)

        AssessmentImport.GRS_Account_KEY = oasis_data(30)

        AssessmentImport.GRS_OASIS_KEY = oasis_data(31)

        AssessmentImport.IdentifyCaseAdministrator = oasis_data(32)

        AssessmentImport.Item99 = oasis_data(33)

        AssessmentImport.LastInpatientStayAdmission = oasis_data(34)

        AssessmentImport.LastInpatientStayDischarge = oasis_data(35)

        AssessmentImport.MedicareCovered = oasis_data(36)

        AssessmentImport.Medication = oasis_data(37)

        AssessmentImport.MS = oasis_data(38)

        AssessmentImport.MS_Desc = oasis_data(39)

        AssessmentImport.Nutrition = oasis_data(40)

        AssessmentImport.Orders = oasis_data(41)

        AssessmentImport.PatientAddress1 = oasis_data(42)

        AssessmentImport.PatientAddress2 = oasis_data(43)

        AssessmentImport.PatientCity = oasis_data(44)

        AssessmentImport.PatientHomePhone = oasis_data(45)

        AssessmentImport.PatientReceivingCare = oasis_data(46)

        AssessmentImport.POTSigned = oasis_data(47)

        AssessmentImport.Prognosis = oasis_data(48)

        AssessmentImport.Safety = oasis_data(49)

        AssessmentImport.Supplies = oasis_data(50)

        AssessmentImport.VerbalSOC = oasis_data(51)

        Dim return_oasis_id As Integer

        Try
            return_oasis_id = AssessmentImport.Import()
        Catch ex As Exception
            Throw New Exception(ex.Message)
        End Try


        Return return_oasis_id
    End Function


    Private Function AddVisitNotesForPatient(ByVal username As String, ByVal password As String, ByVal encounter_data() As String) As ChargeItem Implements IService.AddVisitNotesForPatient

        Dim agency_id As String
        agency_id = LoginAdmin(username, password, encounter_data(0))

        Dim agen_id As SynergyID
        agen_id = New SynergyID(agency_id)

        Dim agency_id_int As Integer
        Integer.TryParse(agency_id, agency_id_int)



        'Dim response As List(Of HomeHealthAgency)
        'Dim login_obj As Object = New HealthCareSynergyLogin.Login
        'response = login_obj.loginandreturnlistofagencies(username, password)
        'Dim ret_string As HomeHealthAgency ' = response.item(0).label.agencycode
        'Dim ag_flag As String

        'If response.Count > 0 Then
        '    For Each ag In response
        '        If ag.AgencyCode = encounter_data(0) Then
        '            ret_string = ag
        '            login_obj.selectagencyandconnecttodatabase(ag)
        '            ag_flag = 1
        '        End If
        '    Next
        '    If ag_flag <> 1 Then
        '        Throw New System.Exception("agency login information and agency id does not match" & response.Item(0).Label.AgencyCode)
        '    End If
        'End If


        Dim agencyCode As New AgencyLabel(agen_id, encounter_data(1))

        Dim dictionaryLookup As New LookUpReference()

        Dim caregivers As List(Of SynergyNameValue) = dictionaryLookup.Caregiver(False)

        Dim accounts As List(Of SynergyNameValue) = dictionaryLookup.Account(False)

        Dim patients As List(Of SynergyNameValue) = dictionaryLookup.Patient(False)

        'Create Visit

        Dim visitAPI As New HCSVisit()
        Dim return_charge As ChargeItem
        Dim patCode As SynergyUserID
        patCode = GetPatientID(encounter_data(2))
        'For Each mypatient In patients
        '    If mypatient.Entry.EntryId.ID = encounter_data(2) Then

        '        patCode = mypatient.Entry.EntryId
        '    End If
        'Next


        Dim patientLabel As New ChartLabel(agencyCode, patCode)

        patientLabel.Agency = agencyCode
        patientLabel.MedicalRecordNumber = encounter_data(4)
        patientLabel.StartOfCare = encounter_data(5)

        Dim VisitNote As ChargeItem = visitAPI.RetrieveNewChargeItem(patientLabel)
        VisitNote.BillingUnits = encounter_data(11)

        VisitNote.BillInsurance = New SynergyBoolean(encounter_data(12))

        Dim care_flag As Integer
        Dim careCode As SynergyBaseID
        For Each myCareGiver In caregivers
            If myCareGiver.Entry.EntryId.ID = encounter_data(7) Then
                careCode = myCareGiver.Entry.EntryId
                care_flag = 1
            End If
        Next

        If care_flag <> 1 Then
            Throw New Exception("Given Caregiver ID for the selected Agency does not match with Synergy")
        Else
            VisitNote.Caregiver.Reference = careCode
        End If

        VisitNote.TimeIn = New SynergyTime(encounter_data(9))

        VisitNote.TimeOut = New SynergyTime(encounter_data(10))

        VisitNote.NotesIn = encounter_data(13)

        VisitNote.Verified = encounter_data(14)

        Dim pos As New HSIAccess.PatientServiceLocation
        For Each pos In VisitNote.PlaceOfService
            If pos.Key = encounter_data(15) Then
                VisitNote.PlaceOfService = pos
            End If
        Next

        VisitNote.TypeOfService = VisitNote.TypeOfService(encounter_data(17))

        VisitNote.Modifiers.Entries(0) = encounter_data(19)

        VisitNote.Modifiers.Entries(1) = encounter_data(20)

        VisitNote.Modifiers.Entries(2) = encounter_data(21)

        VisitNote.Modifiers.Entries(3) = encounter_data(22)

        VisitNote.Label.ChargeAccount.BillingUnitType = VisitNote.Label.ChargeAccount.BillingUnitType.Item(1)

        Dim m_AcctToUse As SynergyNameValue
        For Each acct As SynergyNameValue In accounts
            If encounter_data(24) = acct.Entry.EntryId.ID Then
                m_AcctToUse = acct
                Exit For
            End If
        Next

        VisitNote.Label.ChargeAccount.AccountCode = m_AcctToUse.Entry.EntryId
        Dim mydate As String = encounter_data(23)
        Dim dat As Date
        dat = DateTime.Parse(mydate)

        VisitNote.Label.PeriodStart = New SynergyDate(dat)

        Try
            return_charge = visitAPI.AddVisitNote(patientLabel, VisitNote)
        Catch ex_key As KeyNotFoundException
            Throw New Exception("Duplicate Visit")
        Catch ex As Exception
            Try
                return_charge = visitAPI.AddVisitNoteWithWarnings(patientLabel, VisitNote)
            Catch ex_warning As Exception
                Throw New Exception(ex_warning.Message)
            End Try
        End Try

        Return return_charge

    End Function

    Function Ports() As Object
        Throw New NotImplementedException
    End Function

    Public Function GetPatientID(ByVal PatientCode As String) As SynergyUserID
        Dim lookup As New LookUpReference
        Dim patientList = Lookup.Patient(False)
        If patientList.Count < 1 Then Throw New Exception("Patient List is Empty in Synergy")
        Dim patient = patientList.Where(Function(x) x.Name = PatientCode.ToString)

        If patient.Count < 1 Then Throw New Exception("Cannot find Patient ID: " & PatientCode & " in the selected Agency")

        Return patient(0).Entry.EntryId
    End Function

End Class

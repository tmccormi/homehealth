' NOTE: You can use the "Rename" command on the context menu to change the class name "Service1" in code, svc and config file together.
Imports HealthCareSynergyLogin
Imports HSIAccess
Imports HSIProvider
Imports HealthCareSynergyPatientsCharts
Imports HSIPatientRepository
Imports HealthCareSynergyInc
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

Public Class Service
    Implements IService

    Public Sub New()
    End Sub

    Public Function LoginAdmin(ByVal username As String, ByVal password As String) As List(Of HealthAgency) Implements IService.LoginAdmin
        Dim response As List(Of HealthAgency)
        Dim login_obj As Object = New HealthCareSynergyLogin.Login
        response = login_obj.Login(username, password)
        Return response
    End Function
    Public Function AddDemographics(ByVal username As String, ByVal password As String, ByVal patient_data() As String) As Patient Implements IService.AddDemographics
        Dim login_response As List(Of HealthAgency)
        login_response = LoginAdmin(username, password)


        'Dim response As List(Of HealthAgency)
        'Dim login_obj As Object = New HealthCareSynergyLogin.Login
        'response = login_obj.LoginAndReturnListOfAgencies("SUPERVISOR", "SYNERGY")

        Dim agen_id As SynergyID
        agen_id = New SynergyID("1")
        Dim Agency As New AgencyLabel(agen_id, patient_data(7))
        'login_obj.SelectAgencyAndConnectToDatabase(response.Item(0))

        Dim default_patient As Patient
        Dim patient_obj As Object = New HealthCareSynergyPatientsCharts.HCSPatient
        default_patient = patient_obj.RetrievePatientDefaultWithCode(1, patient_data(14))
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




        Dim doc_obj As Object = New HSIProvider.Physician
        Dim doc_return As List(Of HSIProvider.Physician)
        Dim doc_1 As HSIProvider.Physician
        Dim doc_id As SynergyUserID
        doc_return = doc_obj.GetPhysicianList()
        For Each this_doc In doc_return
            If this_doc.ProviderCode.ID = patient_data(19) Then
                doc_1 = this_doc
                doc_id = doc_1.ProviderCode
                Exit For
            End If
        Next
        'phy_id = phy_1.ProviderCode
        default_patient.DoctorCode = doc_id

        Dim ref_obj As Object = New HSIReferralSource.ReferralSourceRepository
        Dim ref_return As List(Of HSIReferralSource.ReferralSource)
        ref_return = ref_obj.RetrieveReferralSources(1)
        Dim ref_1 As HSIReferralSource.ReferralSource
        Dim ref_id As SynergyUserID
        For Each ref_src In ref_return
            If ref_src.ReferralCode.ID = patient_data(28) Then
                ref_1 = ref_src
                ref_id = ref_1.ReferralCode
                Exit For
            End If
        Next
        'ref_id = ref_1.ReferralCode
        default_patient.ReferralCode = ref_id

        Dim phy_obj As Object = New HSIProvider.Physician
        Dim phy_return As List(Of HSIProvider.Physician)
        Dim phy_1 As HSIProvider.Physician
        Dim phy_id As SynergyUserID
        phy_return = phy_obj.GetPhysicianList()
        For Each prim_doc In phy_return
            If prim_doc.ProviderCode.ID = patient_data(27) Then
                phy_1 = prim_doc
                phy_id = phy_1.ProviderCode
                Exit For
            End If
        Next
        default_patient.PrimaryDoctorCode = phy_id
        default_patient.AssociatedAgency = Agency
        default_patient.OfficeCode = "1"

        patient_obj.CreatePatient(default_patient)
        Return default_patient
    End Function
    Public Function EditDemographics(ByVal username As String, ByVal password As String, ByVal patient_data() As String) As Patient Implements IService.EditDemographics

        Dim login_response As List(Of HealthAgency)
        login_response = LoginAdmin(username, password)

        Dim SynergyID As SynergyBaseID
        Dim WorkingPatient As New HCSPatient
        Dim UpdatingPatient As Patient
        SynergyID = New SynergyBaseID(patient_data(14))
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


        Dim doc_obj As Object = New HSIProvider.Physician
        Dim doc_return As List(Of HSIProvider.Physician)
        Dim doc_1 As HSIProvider.Physician
        Dim doc_id As SynergyUserID
        doc_return = doc_obj.GetPhysicianList()
        For Each this_doc In doc_return
            If this_doc.ProviderCode.ID = patient_data(19) Then
                doc_1 = this_doc
                doc_id = doc_1.ProviderCode
                Exit For
            End If
        Next
        UpdatingPatient.DoctorCode = doc_id

        Dim ref_obj As Object = New HSIReferralSource.ReferralSourceRepository
        Dim ref_return As List(Of HSIReferralSource.ReferralSource)
        ref_return = ref_obj.RetrieveReferralSources(1)
        Dim ref_1 As HSIReferralSource.ReferralSource
        Dim ref_id As SynergyUserID
        For Each ref_src In ref_return
            If ref_src.ReferralCode.ID = patient_data(28) Then
                ref_1 = ref_src
                ref_id = ref_1.ReferralCode
                Exit For
            End If
        Next
        UpdatingPatient.ReferralCode = ref_id

        Dim phy_obj As Object = New HSIProvider.Physician
        Dim phy_return As List(Of HSIProvider.Physician)
        Dim phy_1 As HSIProvider.Physician
        Dim phy_id As SynergyUserID
        phy_return = phy_obj.GetPhysicianList()
        For Each prim_doc In phy_return
            If prim_doc.ProviderCode.ID = patient_data(27) Then
                phy_1 = prim_doc
                phy_id = phy_1.ProviderCode
                Exit For
            End If
        Next
        UpdatingPatient.PrimaryDoctorCode = phy_id

        Dim agen_id As SynergyID
        agen_id = New SynergyID("1")
        Dim Agency As New AgencyLabel(agen_id, patient_data(7))
        UpdatingPatient.AssociatedAgency = Agency
        UpdatingPatient.OfficeCode = "1"
        patient_obj.UpdatePatient(UpdatingPatient)
        Return UpdatingPatient

    End Function
    'Delete Patient
    Public Function DeleteDemographics(ByVal username As String, ByVal password As String, ByVal patient_id As String) As String Implements IService.DeleteDemographics

        Dim login_response As List(Of HealthAgency)
        login_response = LoginAdmin(username, password)
        Dim SynergyID As SynergyBaseID
        Dim Patienthcs As New HCSPatient
        Dim RetrievedPatient As Patient
        SynergyID = New SynergyBaseID(patient_id)
        RetrievedPatient = Patienthcs.RetrievePatient(SynergyID)
        Patienthcs.DeletePatient(RetrievedPatient)
        Return "Success"
    End Function
    'For Oasis
    Public Function ImportAnAssessment(ByVal username As String, ByVal password As String, ByVal oasis_data() As String) As Integer Implements IService.ImportAnAssessment

        Dim login_response As List(Of HealthAgency)
        login_response = LoginAdmin("SUPERVISOR", "SYNERGY")
        Dim AssessmentImport As New HealthCareSynergyOASIS.OASISAnd485Import("1", oasis_data(1), "", "")

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
        return_oasis_id = AssessmentImport.Import()

        Return return_oasis_id
    End Function


    Private Function AddVisitNotesForPatient(ByVal username As String, ByVal password As String, ByVal encounter_data() As String) As ChargeItem Implements IService.AddVisitNotesForPatient

        Dim login_response As List(Of HealthAgency)

        login_response = LoginAdmin(username, password)

        Dim agencyCode As AgencyLabel = login_response(0).Label

        'Return login_response

        Dim dictionaryLookup As New LookUpReference()

        Dim caregivers As List(Of SynergyNameValue) = dictionaryLookup.Caregiver(False)

        Dim accounts As List(Of SynergyNameValue) = dictionaryLookup.Account(False)

        Dim patients As List(Of SynergyNameValue) = dictionaryLookup.Patient(False)

        'Create Visit

        Dim visitAPI As New HCSVisit()
        Dim return_charge As ChargeItem
        Dim patCode As SynergyBaseID
        For Each mypatient In patients
            If mypatient.Entry.EntryId.ID = encounter_data(2) Then

                patCode = mypatient.Entry.EntryId
            End If
        Next


        Dim patientLabel As New ChartLabel(agencyCode, patCode)

        patientLabel.Agency = agencyCode
        patientLabel.MedicalRecordNumber = encounter_data(4)
        patientLabel.StartOfCare = encounter_data(5)

        Dim VisitNote As ChargeItem = visitAPI.RetrieveNewChargeItem(patientLabel)
        VisitNote.BillingUnits = encounter_data(11)

        VisitNote.BillInsurance = New SynergyBoolean(encounter_data(12))


        Dim careCode As SynergyBaseID
        For Each myCareGiver In caregivers
            If myCareGiver.Entry.EntryId.ID = encounter_data(7) Then
                careCode = myCareGiver.Entry.EntryId
                VisitNote.Caregiver.Reference = careCode
            End If
        Next




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

        VisitNote.Label.ChargeAccount.AccountCode = accounts(13).Entry.EntryId
        Dim mydate As String = encounter_data(23)
        Dim dat As Date
        dat = DateTime.Parse(mydate)

        'VisitNote.Label.PeriodStart = New SynergyDate(#6/1/2008#)
        VisitNote.Label.PeriodStart = New SynergyDate(dat)

        Try
            return_charge = visitAPI.AddVisitNote(patientLabel, VisitNote)

        Catch ex As Exception

            return_charge = visitAPI.AddVisitNoteWithWarnings(patientLabel, VisitNote)

        End Try

        Return return_charge

    End Function

    Private Function EditVisitNote(ByVal username As String, ByVal password As String, ByVal encounter_data() As String, ByVal synergy_id As String) As HCSVisit Implements IService.EditVisitNote

        Dim login_response As List(Of HealthAgency)

        login_response = LoginAdmin(username, password)

        Dim agencyCode As AgencyLabel = login_response(0).Label

        'Return login_response

        Dim dictionaryLookup As New LookUpReference()

        Dim caregivers As List(Of SynergyNameValue) = dictionaryLookup.Caregiver(False)

        Dim accounts As List(Of SynergyNameValue) = dictionaryLookup.Account(False)

        Dim patients As List(Of SynergyNameValue) = dictionaryLookup.Patient(False)

        'Create Visit

        Dim visitAPI As New HCSVisit()

        Dim patCode As SynergyBaseID
        For Each mypatient In patients
            If mypatient.Entry.EntryId.ID = encounter_data(2) Then
                patCode = mypatient.Entry.EntryId
            End If
        Next


        Dim patientLabel As New ChartLabel(agencyCode, patCode)

        patientLabel.Agency = agencyCode
        patientLabel.MedicalRecordNumber = encounter_data(4)
        patientLabel.StartOfCare = encounter_data(5)

        Dim ledger_list As List(Of LedgerLabel)
        ledger_list = RetrieveSynergyLedger(username, password, encounter_data(2))
        Dim ledger_code As SynergyID
        For Each myledger In ledger_list
            If myledger.LedgerCode.ID = synergy_id Then
                ledger_code = myledger.LedgerCode
            End If
        Next
        Dim VisitNote As ChargeItem = visitAPI.RetrieveLedgerItem(ledger_code)
        VisitNote.BillingUnits = encounter_data(11)

        VisitNote.BillInsurance = New SynergyBoolean(encounter_data(12))


        Dim careCode As SynergyBaseID
        For Each myCareGiver In caregivers
            If myCareGiver.Entry.EntryId.ID = encounter_data(7) Then
                careCode = myCareGiver.Entry.EntryId
                VisitNote.Caregiver.Reference = careCode
            End If
        Next




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

        VisitNote.Label.ChargeAccount.AccountCode = accounts(13).Entry.EntryId
        Dim mydate As String = encounter_data(23)
        Dim dat As Date
        dat = DateTime.Parse(mydate)

        VisitNote.Label.PeriodStart = New SynergyDate(dat)

        Try
            visitAPI.EditVisitNote(patientLabel, VisitNote)

        Catch ex As Exception

            visitAPI.EditVisitNoteWithWarnings(patientLabel, VisitNote)

        End Try

        Return visitAPI

    End Function

    Private Function RetrieveSynergyLedger(ByVal username As String, ByVal password As String, ByVal patient_code As String) As List(Of LedgerLabel) Implements IService.RetrieveSynergyLedger

        Dim login_response As List(Of HealthAgency)
        login_response = LoginAdmin(username, password)
        Dim ledgers As List(Of LedgerLabel)
        Dim patCode As SynergyBaseID
        Dim dictionaryLookup As New LookUpReference()
        Dim patients As List(Of SynergyNameValue) = dictionaryLookup.Patient(False)
        Dim visitAPI As New HCSVisit()

        For Each mypatient In patients
            If mypatient.Entry.EntryId.ID = patient_code Then
                patCode = mypatient.Entry.EntryId
            End If
        Next
        ledgers = visitAPI.RetrieveCompletePatientLedger(patCode)


        Return ledgers

    End Function


    Private Function DeleteVisitNote(ByVal username As String, ByVal password As String, ByVal patient_id As String, ByVal synergy_id As String) As HCSVisit Implements IService.DeleteVisitNote

        Dim login_response As List(Of HealthAgency)
        login_response = LoginAdmin(username, password)
        Dim visitAPI As New HCSVisit
        Dim agencyCode As AgencyLabel = login_response(0).Label
        Dim ledger_list As List(Of LedgerLabel)
        ledger_list = RetrieveSynergyLedger(username, password, patient_id)
        Dim ledger_code As SynergyID
        For Each myledger In ledger_list
            If myledger.LedgerCode.ID = synergy_id Then
                ledger_code = myledger.LedgerCode
            End If
        Next
        Dim VisitNote As ChargeItem = visitAPI.RetrieveLedgerItem(ledger_code)

        Try
            visitAPI.DeleteVisitNote(VisitNote)
        Catch ex As Exception
            visitAPI.DeleteVisitNoteWithWarnings(VisitNote)
        End Try

        Return visitAPI
    End Function

End Class

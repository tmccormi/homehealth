' NOTE: You can use the "Rename" command on the context menu to change the interface name "IService" in both code and config file together.
Imports HSIAccess
Imports HSIProvider
Imports HealthCareSynergyPatientsCharts
Imports HSIPatientRepository
Imports HSIReferralSource
Imports HealthCareAssistant
Imports Ledger
Imports HealthCareSynergyOASIS
Imports HSIChartUtilities
Imports System.ServiceModel
Imports System.Runtime.Serialization
Imports HSIOasisEvaluation
Imports HSIPatientChart
Imports System.Data

' NOTE: You can use the "Rename" command on the context menu to change the interface name "IService1" in both code and config file together.
<ServiceContract()>
Public Interface IService

    <OperationContract()>
    Function LoginAdmin(ByVal username As String, ByVal password As String) As List(Of HealthAgency)

    <OperationContract()>
    Function AddDemographics(ByVal username As String, ByVal password As String, ByVal patient_data() As String) As Patient

    <OperationContract()>
    Function EditDemographics(ByVal username As String, ByVal password As String, ByVal patient_data() As String) As Patient

    <OperationContract()>
    Function DeleteDemographics(ByVal username As String, ByVal password As String, ByVal patient_id As String) As String

    <OperationContract()>
    Function ImportAnAssessment(ByVal username As String, ByVal password As String, ByVal oasis_data() As String) As Integer

    <OperationContract()>
    Function AddVisitNotesForPatient(ByVal username As String, ByVal password As String, ByVal encounter_data() As String) As ChargeItem

    <OperationContract()>
    Function EditVisitNote(ByVal username As String, ByVal password As String, ByVal encounter_data() As String, ByVal synergy_id As String) As HCSVisit

    <OperationContract()>
    Function RetrieveSynergyLedger(ByVal username As String, ByVal password As String, ByVal patient_code As String) As List(Of LedgerLabel)

    <OperationContract()>
    Function DeleteVisitNote(ByVal username As String, ByVal password As String, ByVal patient_id As String, ByVal synergy_id As String) As HCSVisit


    ' TODO: Add your service operations here

End Interface

' Use a data contract as illustrated in the sample below to add composite types to service operations.

<DataContract()>
Public Class CompositeType

    <DataMember()>
    Public Property BoolValue() As Boolean

    <DataMember()>
    Public Property StringValue() As String

End Class

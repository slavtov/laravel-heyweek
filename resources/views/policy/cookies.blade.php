@extends('layouts.default')

@section('title', __('policy.cookies'))

@section('content')
<h1 class="font-weight-bold">
  {{ __('policy.cookies') }}
</h1>

<p class="text-muted my-3">
  {{ __('policy.updated') }}:
  {{ __('policy.date_cookies') }}
</p>

<p>Text</p>

<h5 class="font-weight-bold">How we use cookies</h5>

<p>When you use and access the Website, we may place a number of cookies files in your web browser.</p>
<p>We use cookies for the following purposes: to enable certain functions of the Website, to provide analytics, to store your preferences, to enable advertisements delivery, including behavioral advertising.</p>
<p>We use both session and persistent Cookies for the purposes set out below:</p>

<table class="table table-bordered">
  <thead class="thead-light text-center">
    <tr class="text-nowrap">
      <th scope="col">Name</th>
      <th scope="col">Type</th>
      <th scope="col">Administered by</th>
      <th scope="col">Purpose</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Necessary/Essential cookies</td>
      <td>Session Cookies</td>
      <td>Us</td>
      <td>These Cookies are essential to provide You with services available through the Website and to enable You to use some of its features. They help to authenticate users and prevent fraudulent use of user accounts. Without these Cookies, the services that You have asked for cannot be provided, and We only use these Cookies to provide You with those services.</td>
    </tr>
    <tr>
      <td>Functionality/Preferences cookies</td>
      <td>Persistent Cookies</td>
      <td>Us</td>
      <td>These Cookies allow us to remember choices You make when You use the Website, such as remembering your login details or language preference. The purpose of these Cookies is to provide You with a more personal experience and to avoid You having to re-enter your preferences every time You use the Website.</td>
    </tr>
    <tr>
      <td>Analytics and Performance cookies</td>
      <td>Session/Persistent Cookies</td>
      <td>Thid-Parties</td>
      <td>These cookies are used to collect information about traffic to our Website and how users use our Website. The information gathered does not identify any individual visitor. The information is aggregated and anonymous. It includes the number of visitors to our Website, the websites that referred them to our Website, the pages they visited on our Website, what time of day they visited our Website, whether they have visited our Website before, and other similar information. We use this information to help operate our Website more efficiently, to gather broad demographic information and to monitor the level of activity on our Website.</td>
    </tr>
    <tr>
      <td>Targeting and Advertising Cookies</td>
      <td>Persistent Cookies</td>
      <td>Third-Parties</td>
      <td>These Cookies track your browsing habits to enable Us to show advertising which is more likely to be of interest to You. These Cookies use information about your browsing history to group You with other users who have similar interests. Based on that information, and with Our permission, third party advertisers can place Cookies to enable them to show adverts which We think will be relevant to your interests while You are on third party websites.</td>
    </tr>
    <tr>
      <td>Social Media Cookies</td>
      <td>Persistent</td>
      <td>Third-Parties</td>
      <td>We may also use various third parties Cookies to report usage statistics of the Website, deliver advertisements on and through the Website, and so on. These Cookies may be used when You share information using a social media networking website such as Facebook, Instagram, Twitter, and so on.</td>
    </tr>
  </tbody>
</table>

<h5 class="font-weight-bold">Contact Us</h5>

<p>If you have any questions about this Cookie Policy, You can contact us:</p>

<ul>
  <li>By email: support{{ '@' . request()->getHost() }}</li>
  <li>
    By visiting this page on our website:
    <a href="{{ route('contact') }}">
      Click here
    </a>
  </li>
</ul>
@endsection

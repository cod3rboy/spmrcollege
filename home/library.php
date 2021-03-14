<?php
    //Setting page title
    $page_title = 'Library';
    //Include Header code
    require("../templates/common/header.php");
?>
<!--Bootstrap Container-->
<div class="container">
    <!--Bootstrap Row-->
    <div class="row">
        <!--Bootstrap Column-->
        <div class="col-xs-12">
            <!--Page Container-->
            <div class="page-container" id="scroll-content">
                <!--Page Header-->
                <div class="page-header">
                    <a class="page-header-link" href="index.php">Home</a> / 
                    <a class="page-header-link" href="facilities.php">Facilities</a> / 
                    <a class="page-header-link" href="academicfacilities.php">Academic Facilities</a> / 
                    Library
                </div>
                <!--End Page Header-->
                <!--Page Body-->
                <div class="page-body">
                        <!--Page Logo-->
                        <img class="img-responsive page-logo" alt="books icon" src="../images/books.png">
                        <hr class="hr-divider">
                        <!--Top Section-->
                        <ul>
                            <li>The college library has a collection of more than 40,000 text and reference books besides a number of journals, magazines, periodicals, newsletters and newspapers.</li>
                            <li>Facilities of Reading Room and Reference Section are also provided to the students. With the help of the University Grants Commission, a Text Book Section has also been established where a large number of text books are made available to the needy and deserving students. </li>
                            <li>A photocopying machine has been installed in the library for the staff and the students to make use of it at a nominal cost.</li>
                        </ul>
                        <!--End Top Section-->
                        <hr class="hr-divider">
                        <!--Library Rules Section-->
                        <div class="md-heading page-content-header bar-header"><span class="glyphicon glyphicon-list-alt"></span> Library Rules</div>
                        <div class="page-content">
                            <ol class="o-list">
                                <li>Besides the normal college working days, the college Library remains open for students during the summer/ winter vacation also.</li>
                                <li>Every student at the time of borrowing books from the Library shall present to the Librarian his borrower card issued by the Chief Librarian. A student can normally borrow one book at a time.</li>
                                <li>Meritorious students will be extended the facility of borrowing two books at a time.</li>
                                <li>A student must return the books borrowed by him within 15 days. A student who retains a book beyond the prescribed limit shall have to pay a fine of Re.1 per day per book subject to maximum of twice the cost of the book/books.</li>
                                <li>Reference books, rare books, specially reserved and current periodicals will not be issued for home use. These can be consulted only within the Library premises.</li>
                                <li>Strict silence shall be observed in the Library and reading rooms. Students shall not take their personal books or belongings inside the library.</li>
                                <li>A duplicate copy of the Library card is issued on payment of Rs. 100/-. Thereafter, no duplicate card shall be issued. However, a mutilated card is replaced on surrendering the original card for a fee of Rs. 100/-.</li>
                                <li>A student appearing in the University Examination shall surrender his borrower card to the Library for cancellation before receiving his Roll No. Slip. Any student who fails to surrender his card shall be charged a fine of Rs. 200/-.</li>
                                <li>The same student may not borrow the same book for the second time within two days from the date of its return.</li>
                                <li>Any student who loses or returns a tampered book, shall be liable to pay an amount not less than double the cost of the book. When the book is a part of a set or a series, he has to pay the cost of the whole set/ series unless he can replace the damaged book volume.</li>
                                <li>Students are expected to visit the library regularly. Any infringement of the library rules shall incur punishment.</li>
                            </ol>
                        </div>
                    <!--End Library Rules Section-->
                </div>
                <!--End Page Body-->
            </div>
            <!--End Page Container-->
        </div>
        <!--End Bootstrap Column-->
    </div>
    <!--End Bootstrap Row-->
</div>
<!--End Bootstrap Container-->

<?php
    //Include Footer Code
    require("../templates/common/footer.php");
?>
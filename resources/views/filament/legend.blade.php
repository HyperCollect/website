<!-- Legend table -->
<style>
    .leg table {
        border-spacing: 0;
        border-collapse: separate;
        border-radius: 10px;
    }
    .leg td,
    .leg th {
        padding: 4px;
        /* background-color: #18181b; */
        border-radius: 10px;
        border-bottom: 1px solid #000000;
    }
    
    .leg td:first-child {
        white-space: nowrap;
        border-right: 1px solid #000000;
    }
    .leg th {
        text-align: left;
    }
    .tablecontainer {
        background-color: white;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #eaeaea;
    }
</style>
<div class="tablecontainer">
    <table class="leg">
        <thead>
            <tr>
                <th>Legend</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Name</td>
                <td>Name of hypergraph</td>
            </tr>
            <tr>
                <td>Author</td>
                <td>User that uploaded the hypergraph</td>
            </tr>
            <tr>
                <td>|V|</td>
                <td>Number of nodes</td>
            </tr>
            <tr>
                <td>|E|</td>
                <td>Number of hyperedges</td>
            </tr>
            <tr>
                <td>
                    d<sub>max</sub>
                </td>
                <td>Maximum node degree</td>
            </tr>
            <tr>
                <td>
                    d<sub>avg</sub>
                </td>
                <td>Average node degree</td>
            </tr>
            <tr>
                <td>
                    e<sub>max</sub>
                </td>
                <td>Maximum hyperedge size</td>
            </tr>
            <tr>
                <td>
                    e<sub>avg</sub>
                </td>
                <td>Average hyperedge size</td>
            </tr>
        </tbody>
    </table>
</div>

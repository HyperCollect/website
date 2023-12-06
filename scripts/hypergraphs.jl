using Suppressor
@suppress begin
    using SimpleHypergraphs
end
# using SimpleHypergraphs

function build_hg(path)

    nodes = Dict{Int,Int}()
    nodes_per_edge = Dict{Int,Vector{Int}}()

    hg = Hypergraph(0,0)

    for line in eachline(path)
        # split elemnts of the line by comma
        d = split(line, ",")
        vs = map(x -> parse(Int,(strip(replace(x, r"\[|\]" => "")))), d)
        for v in vs
            if !haskey(nodes, v)
                v_id = SimpleHypergraphs.add_vertex!(hg)
                push!(nodes, v=>v_id)
            end
        end
        # add he 
        vertices = Dict{Int, Bool}(nodes[v] => true for v in vs)
        he_id = SimpleHypergraphs.add_hyperedge!(hg; vertices = vertices)
        push!(nodes_per_edge, he_id => vs)  
    end

    return hg, nodes, nodes_per_edge
end

function node_degree_histogram(hg; normalized=false) 
    hist = Dict{Int,Union{Int,Float64}}()
    
    for v in 1:nhv(hg)      
        deg = length(gethyperedges(hg, v))
        hist[deg] = get(hist, deg, 0) + 1
    end

    if normalized
        for (deg, count) in hist
            hist[deg] = count / nhv(hg)
        end

        return hist
    end

    return hist
end

# return a dict with key = degree of vertices and value = number of vertices with that length
# normalized = true if you want the values to be normalized
function edge_degree_histogram(hg; normalized=false) 
    hist = Dict{Int,Union{Int,Float64}}()

    for he in 1:nhe(hg)      
        s = length(getvertices(hg, he))
        hist[s] = get(hist, s, 0) + 1
    end

    if normalized
        for (s, count) in hist
            hist[s] = count / nhe(hg)
        end

        return hist
    end

    return hist
end

function listNodeDegree(hg)
    degrees = []
    for v in 1:nhv(hg)
        deg = length(gethyperedges(hg, v))
        push!(degrees, deg)
    end
    return degrees
end

function listEdgeDegree(hg)
    sizes = []
    for he in 1:nhe(hg)
        s = length(getvertices(hg, he))
        push!(sizes, s)
    end
    return sizes
end

function infos(hg)
    nodes = nhv(hg)
    edges = nhe(hg) 
    avg_node_degree = sum([length(gethyperedges(hg, v)) for v in 1:nodes]) / nodes
    avg_edge_degree = sum([length(getvertices(hg, he)) for he in 1:edges]) / edges
    # distribution_node_degree = node_degree_histogram(hg, normalized=false)
    # distribution_edge_size = edge_degree_histogram(hg, normalized=false)
    distribution_node_degree = listNodeDegree(hg)
    distribution_edge_size = listEdgeDegree(hg)
    node_degree_max = maximum(keys(distribution_node_degree))
    edge_degree_max = maximum(keys(distribution_edge_size))
    return (nodes, edges, avg_node_degree, avg_edge_degree, distribution_node_degree, distribution_edge_size, node_degree_max, edge_degree_max)
end

function collect_infos(path)
    hg = build_hg(path)[1]
    info = infos(hg)
    return info
end


